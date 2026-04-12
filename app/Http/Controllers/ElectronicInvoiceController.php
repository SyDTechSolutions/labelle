<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ElectronicInvoice;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Mail\SendIElectronicInvoice;
use Illuminate\Support\Facades\Storage;
use App\FacturaElectronica\Factura;
use Illuminate\Support\Facades\Validator;
use App\FacturaElectronica\Tiquete;
use App\Services\FacturaElectronicaService;
use Illuminate\Support\Arr;
use NumberFormatter;

class ElectronicInvoiceController extends Controller
{
    public function __construct(FacturaElectronicaService $facturaService)
    {
        $this->middleware('auth');
        $this->setting = \App\Setting::first();
        $this->facturaService = $facturaService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
        $search['sent_to_hacienda'] = request('sent_to_hacienda');
        $search['status_fe'] = request('status_fe');
        $search['created_by'] = request('created_by');

        $electronicInvoices = ElectronicInvoice::search($search)->where('canceled', 0)->latest()->paginate(10);
       
        return view('electronicInvoice.index', compact('electronicInvoices', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('electronicInvoice.create',[
            'tipoDocumento' => '08'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'pay_with' => 'numeric'
        ]);

        $v->sometimes('PlazoCredito', 'required', function ($input) {
            return $input->CondicionVenta == '02';
        });

        $v->sometimes('tipo_identificacion_emisor', 'required', function ($input) {
            return $input->identificacion_emisor != '' || ($input->TipoDocumento == '01' || $input->TipoDocumento == '08');
        });

        $v->sometimes('identificacion_emisor', 'required|numeric', function ($input) {
            return $input->tipo_identificacion_emisor != '' || ($input->TipoDocumento == '01' || $input->TipoDocumento == '08');
        });

        $v->sometimes('identificacion_emisor', 'digits:9', function ($input) {
            return $input->tipo_identificacion_emisor == '01';
        });

        $v->sometimes('identificacion_emisor', 'digits:10', function ($input) {
            return $input->tipo_identificacion_emisor == '02' || $input->tipo_identificacion_cliente == '04';
        });

        $v->sometimes('identificacion_emisor', 'digits_between:11,12', function ($input) {
            return $input->tipo_identificacion_emisor == '03';
        });

        $v->sometimes('emisor', 'required', function ($input) {
            return ($input->tipo_identificacion_emisor != '' && $input->identificacion_emisor != '') || ($input->TipoDocumento == '01' || $input->TipoDocumento == '08');
        });

        $v->validate();

        $config = null;

        if ($this->setting->fe) {

            $config = $this->setting->getObligadoTributario();

            if (!existsCertFile($config)) {

                $errors = [
                    'certificate' => ['Parece que no tienes el certificado de hacienda ATV instalado. Para poder continuar verfica que el médico lo tenga configurado en su perfil']
                ];


                return response()->json(['errors' => $errors], 422, []);
            }

        }

        $data = $this->prepareData(request()->all(), $config);

        $invoice = ElectronicInvoice::create($data);
        
        $invoice = $invoice->saveLines($data['lines']);

        if(isset($data['initialPayment']) && $data['initialPayment']){
            $invoice->payments()->create([
                "amount" => $data['initialPayment']
            ]);
        }

        if ($config && $invoice->status) {

            $result = $this->facturaService->sendDocument($invoice);

            if (!$result) {
                $invoice->update([
                    'sent_to_hacienda' => 1
                ]);


            }
        }

        return $invoice;
    }

    public function sendHacienda(ElectronicInvoice $invoice)
    {
        if( $this->comprobarRecepcion($invoice) ){ //verificamos si ya fue enviado la factura y actualizamos status fe
            \Log::info('Documento Electronico ya habia sido enviado');
            return $invoice;
        }
        
        $result = $this->facturaService->sendDocument($invoice);

        if (!$result) {
            $invoice->update([
                'sent_to_hacienda' => 1,
                'status' => 1
            ]);

            return $invoice;

        }

        return response(['message' => 'Error al enviar'], 422);
    }

    public function comprobarRecepcion(ElectronicInvoice $invoice)
    {
        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $respHacienda = $this->facturaService->recepcionDocument($clave);
       
        
        if (isset($respHacienda->{'ind-estado'})) {

            if($invoice->status_fe != 'aceptado'){
                $invoice->status_fe = $respHacienda->{'ind-estado'};
            }

            if (isset($respHacienda->{'respuesta-xml'})) {
                $invoice->resp_hacienda = json_encode($this->facturaService->decodeRespuestaXML($respHacienda->{'respuesta-xml'}));
            }

            $invoice->sent_to_hacienda = 1;
            $invoice->save();

            return true;
        }

        return false;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = ElectronicInvoice::where('id',$id)
        ->first();

        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }]);

        if (request()->wantsJson()) {
            return response($invoice, 200);
        }
        
        return view('electronicInvoice.edit', [
            'invoice' => $invoice,
            'tipoDocumento' => '08'
            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function prepareData($data, $obligadoTributario = null)
    {
        
         $data['consecutivo'] = $obligadoTributario ? $this->crearConsecutivoHacienda($obligadoTributario, $data['TipoDocumento']) : $this->crearConsecutivo($data['TipoDocumento']);

        if ($obligadoTributario) {
            $data['obligado_tributario_id'] = $obligadoTributario->id;
            $data['sucursal'] = $obligadoTributario->sucursal;
            $data['pos'] = $obligadoTributario->pos;
            $data['fe'] = 1;
        }

        if($data['TipoDocumento'] != '08'){
            $data = Arr::except($data, array('id'));
            $data = Arr::except($data, array('updated_at'));
            $data = Arr::except($data, array('created_at'));
            $data = Arr::except($data, array('NumeroConsecutivo'));
            $data = Arr::except($data, array('clave_fe'));
            $data = Arr::except($data, array('status_fe'));
            $data = Arr::except($data, array('resp_hacienda'));
            $data = Arr::except($data, array('sent_to_hacienda'));
            $data = Arr::except($data, array('created_xml'));
            $data = Arr::except($data, array('created_by'));
        }

        $data['TotalWithNota'] = $data['TotalComprobante'];
        $data['created_by'] = isset($data['created_by']) ? $data['created_by'] : auth()->id();

        if($data['CondicionVenta'] == '02'){ //credito
            $data['cxc_pending_amount'] = $data['TotalComprobante'];
        }
       
        return $data;
    }

     public function crearConsecutivo($tipoDocumento)
    {
        
        $consecutivo_inicio = $this->setting ? $this->setting->consecutivo : 1;

        
        $consecutivo = ElectronicInvoice::where('TipoDocumento', $tipoDocumento)->max('consecutivo');
       

        return ($consecutivo) ? $consecutivo += 1 : $consecutivo_inicio;
    }

    public function crearConsecutivoHacienda($obligadoTributario, $tipoDocumento)
    {
        //$setting = \App\Setting::first();

        $consecutivo_inicio = $this->setting ? $this->setting->consecutivo : 1;


        if ($tipoDocumento == '08') {
            $consecutivo_inicio = $obligadoTributario->consecutivo_inicio_EI;
        }

        $consecutivo = ElectronicInvoice::where('obligado_tributario_id', $obligadoTributario->id)
        ->where('TipoDocumento', $tipoDocumento)
        ->where('sucursal', $obligadoTributario->sucursal)
        ->where('pos', $obligadoTributario->pos)
        ->where('status', 1)
        ->max('consecutivo');


        return ($consecutivo) ? $consecutivo += 1 : $consecutivo_inicio;
    }

    public function saveRespuestaXML($config, $clave, $respHacienda)
    {
        if (isset($respHacienda->{'respuesta-xml'})) {
            Storage::put('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml', base64_decode($respHacienda->{'respuesta-xml'}));
        }
    }

    public function xml(ElectronicInvoice $invoice)
    {
       

        $config = $invoice->obligadoTributario;


        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml')) {
            flash('Archivo no encontrado', 'danger');

            return back();
        }

        return Storage::disk('local')->download('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml');

       // return response()->download($pathToFile);
    }

    public function cancel(ElectronicInvoice $invoice)
    {
        $invoice->update([
            'canceled' => 1,
            'TotalWithNota' => 0
        ]);

        flash('Factura Anulada', 'success');

        return back();
    }

    public function pdf(ElectronicInvoice $invoice)
    {
        $this->validate(request(), [
            'to' => 'required|email_array'
        ]);

        $emails = array_map('trim', array_filter(explode(',', request('to'))));

        //$invoice->load('lines.taxes','creator');
        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'creator']);
        
        $pdf = \PDF::loadView('electronicInvoice.pdf', $invoice->toArray());
        
        $config = $invoice->obligadoTributario;

        $respHacienda = $this->facturaService->recepcionDocument($invoice->clave_fe);

        $this->saveRespuestaXML($config, $invoice->clave_fe, $respHacienda);


        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml')) {
            //flash('Archivo XML no encontrado', 'danger');

            if (request()->wantsJson()) {
                return response('Archivo XML no encontrado', 404);
            }
        }

        $xmlFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml');

        $xmlRespuestaHaciendaFactura = null;

        if (Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml')) {

            $xmlRespuestaHaciendaFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml');
        }


        try {
            \Mail::to($emails)->send(new SendIElectronicInvoice($pdf->output(), $xmlFactura, $xmlRespuestaHaciendaFactura, $invoice));

            if (request()->wantsJson()) {
                return response([], 200);
            }

        } catch (\Swift_TransportException $e) {  //Swift_RfcComplianceException
            if (request()->wantsJson()) {
                return response(['error'], 500);
            }
        }


    }

    public function print(ElectronicInvoice $invoice)
    {
        //$invoice->load('lines.taxes','referencias');
        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        $formatLetras = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $TotalEnLetras = $formatLetras->format($invoice->TotalComprobante);

        return view('electronicInvoice.print', compact('invoice','TotalEnLetras'));
    }
    public function ticket(ElectronicInvoice $invoice)
    {
        //$invoice->load('lines.taxes', 'referencias');
        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes']);

        $formatLetras = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $TotalEnLetras = $formatLetras->format($invoice->TotalComprobante);

        return view('electronicInvoice.ticket', compact('invoice','TotalEnLetras'));
        
    }
}
