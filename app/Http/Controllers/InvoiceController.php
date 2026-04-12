<?php

namespace App\Http\Controllers;

use App\Apis\Factura\Hacienda;
use App\ConfigFactura;
use App\Currency;
use Illuminate\Http\Request;
use App\Invoice;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use App\Mail\SendInvoice;
use Illuminate\Support\Facades\Storage;
use App\FacturaElectronica\Factura;
use App\FacturaElectronica\NotaDebito;
use App\FacturaElectronica\NotaCredito;
use Illuminate\Support\Facades\Validator;
use App\FacturaElectronica\Tiquete;
use App\Proforma;
use App\Services\FacturaService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use NumberFormatter;
use App\Jobs\ValidarRespuestaHacienda;

class InvoiceController extends Controller
{
    public function __construct(FacturaService $facturaService)
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
     
        $invoices = Invoice::search($search)->with('notascreditodebito','referencias')->where('canceled', 0)->latest()->paginate(10);
       
        $currency = Currency::where("name","dollar")->first();

        return view('invoices.index', compact('invoices', 'search','currency'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proforma = null;
        $get = request('p');
        $word  = 'c';
        $check = strpos($get, $word);

        if(request('p')){
            //$proforma = Proforma::with('lines.taxes')->find(request('p'));
            $proforma = Proforma::with(['lines' => function ($query) {
                $query->orderBy('id', 'asc');
            }, 'lines.taxes'])->find(request('p'));
        }

        $currency = Currency::where("name","dollar")->first();

        
        // $dollar = $this->getDollarValue();

        // if($dollar && $dollar > 0){
        //     $currency->exchange = $dollar;
        // }

        if($check){
            return view('invoices.create',[
                'tipoDocumento' => '01',
                'proforma' => $proforma,
                'caja'=>'1',
                'currency'=>$currency
            ]);
        }else{
            return view('invoices.create',[
                'tipoDocumento' => '01',
                'proforma' => $proforma,
                'caja'=>'0',
                'currency'=>$currency
            ]);
        }
    }

    public function reciboPago(Invoice $invoice)
    {
        $currency = Currency::where("name","dollar")->first();

        return view('invoices.create',[
            'invoice' => $invoice->load('lines.taxes','referencias'),
            'tipoDocumento' => '10',
            'creatingNota' => 1,
            'caja'=>'0',
            'currency'=>$currency->exchange
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

        $v->sometimes('tipo_identificacion_cliente', 'required', function ($input) {
            return $input->identificacion_cliente != '' || ($input->TipoDocumento == '01' || $input->TipoDocumento == '08');
        });

        $v->sometimes('identificacion_cliente', 'required|numeric', function ($input) {
            return $input->tipo_identificacion_cliente != '' || ($input->TipoDocumento == '01' || $input->TipoDocumento == '08');
        });

        $v->sometimes('identificacion_cliente', 'digits:9', function ($input) {
            return $input->tipo_identificacion_cliente == '01';
        });

        $v->sometimes('identificacion_cliente', 'digits:10', function ($input) {
            return $input->tipo_identificacion_cliente == '02' || $input->tipo_identificacion_cliente == '04';
        });

        $v->sometimes('identificacion_cliente', 'digits_between:11,12', function ($input) {
            return $input->tipo_identificacion_cliente == '03';
        });

        $v->sometimes('cliente', 'required', function ($input) {
            return ($input->tipo_identificacion_cliente != '' && $input->identificacion_cliente != '') || ($input->TipoDocumento == '01' || $input->TipoDocumento == '08');
        });

        $v->validate();

        $config = null;

        if ($this->setting->fe) {

            $config = $this->setting->getObligadoTributario();
        }

        $data = $this->prepareData(request()->all(), $config);
        
        $invoice = Invoice::create($data);

        $invoice = $invoice->saveLines($data['lines']);

        $invoice = $invoice->saveReferencias($data['referencias']);

        if(isset($data['initialPayment']) && $data['initialPayment']){
            $invoice->payments()->create([
                "amount" => $data['initialPayment']
            ]);
        }

        //Aqui se tiene que enviar al nuevo endpoint de hacienda
        if ($invoice->status && $this->setting->fe) {
            \App\Jobs\EnviarFacturaHacienda::dispatch($invoice->id);
        }

        return $invoice;

    }

    protected function getDollarValue(){
        $current_date = Carbon::now()->format('d/m/Y');
        try{
            $response = Http::get('https://gee.bccr.fi.cr/Indicadores/Suscripciones/WS/wsindicadoreseconomicos.asmx/ObtenerIndicadoresEconomicosXML?Indicador=317&FechaInicio='.$current_date.'&FechaFinal='.$current_date.'&Nombre=Luis Diego Villarreal Venegas&SubNiveles=N&CorreoElectronico=diegovillatj@gmail.com&Token=33DAGILRL6');

            // Decode the HTML entities within the string
            $xmlString = html_entity_decode($response->body());

            // Parse the XML string into a SimpleXMLElement
            $xml = simplexml_load_string($xmlString);

            // Access the NUM_VALOR element
            $numValor = floatval($xml->Datos_de_INGC011_CAT_INDICADORECONOMIC->INGC011_CAT_INDICADORECONOMIC->NUM_VALOR);
        }catch(Exception $e){
            $numValor = 527;
        }
        return $numValor;
    }

    public function sendHacienda(Invoice $invoice)
    {
        if( $this->comprobarRecepcion($invoice) ){
            return $invoice;
        }

        if ($invoice->TipoDocumento != '99' || $invoice->tipo_identificacion_cliente != '99') {

            $hacienda = new Hacienda();
            $result = $hacienda->sendDocument($invoice);
            
            if ($result && isset($result['clave'])) {
                $invoice->update([
                    'clave_fe' => $result['clave'],
                    'status_fe'=> $result['ind-estado'],
                    'created_xml' => 1,
                    'fe'=>1,
                    'resp_hacienda' => json_encode($result),
                ]);
            }

            return $invoice;
        }

        return response(['message' => 'Error al enviar'], 422);
    }

    public function comprobarRecepcion(Invoice $invoice)
    {
        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $hacienda = new Hacienda();
        $respHacienda = $hacienda->getXMLResponse(clave: $clave);
       
        
        if (isset($respHacienda['ind-estado'])) {

            if($invoice->status_fe != 'aceptado'){
                $invoice->status_fe = $respHacienda['ind-estado'];
            }

            if (isset($respHacienda['respuesta-xml'])) {
                $invoice->resp_hacienda = json_encode($this->facturaService->decodeRespuestaXML($respHacienda['respuesta-xml']));
            }

            $invoice->sent_to_hacienda = 1;
            $invoice->save();

            return true;
        }

        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //$invoice->load('lines.taxes','referencias');
        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'referencias']);

        if (request()->wantsJson()) {
            return response($invoice, 200);
        }

         $currency = Currency::where("name","dollar")->first();

        
        // $dollar = $this->getDollarValue();

        // if($dollar && $dollar > 0){
        //     $currency->exchange = $dollar;
        // }

        return view('invoices.edit', [
            'invoice' => $invoice,
            'tipoDocumento' => $invoice->TipoDocumento,
            'caja'=>'0',
            'currency'=>$invoice->ValorDolar
        ]);
    }

    public function updateSeller(Invoice $invoice)
    {
        
            $invoice->update([
                'created_by' => request('created_by'),
                
            ]);

            return $invoice;

       
    }

    public function updateProforma(Proforma $proforma)
    {  
       
        $proforma->update([
            'status' =>1
        ]);

        return $proforma;  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print(Invoice $invoice)
    {
        //$invoice->load('lines.taxes','referencias');
        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'referencias']);

        $formatLetras = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $TotalEnLetras = $formatLetras->format($invoice->TotalComprobante);
        $taxes = $this->getTaxes($invoice->lines);

        return view('invoices.print', compact('invoice','TotalEnLetras','taxes'));
    }

    public function xml(Invoice $invoice)
    {
       

        $config = $invoice->obligadoTributario;


        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml')) {
            flash('Archivo no encontrado', 'danger');

            return back();
        }

        return Storage::disk('local')->download('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml');

       // return response()->download($pathToFile);
    }
    public function pdf(Invoice $invoice)
    {
        $this->validate(request(), [
            'to' => 'required|email_array'
        ]);

        $emails = array_map('trim', array_filter(explode(',', request('to'))));

        //$invoice->load('lines.taxes','creator');
        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'creator']);

        $pdf = \PDF::loadView('invoices.pdf', $invoice->toArray());
        
        $xmlFactura = null;
        $xmlRespuestaHaciendaFactura = null;

        // Solo consultar hacienda si fe está activo
        if ($this->setting->fe && $invoice->clave_fe) {
            $config = ConfigFactura::first();
            $hacienda = new Hacienda();

            $xmls = $hacienda->getXMLResponse(clave: $invoice->clave_fe);

            // Validar que el estado sea aceptado antes de proceder
            if (!isset($xmls['ind-estado']) || $xmls['ind-estado'] !== 'aceptado') {
                if (request()->wantsJson()) {
                    return response(['error' => 'La factura no ha sido aceptada por Hacienda'], 400);
                }
                flash('La factura no ha sido aceptada por Hacienda', 'danger');
                return back();
            }

            // Convertir respuesta-xml de base64 a XML
            if (isset($xmls['respuesta-xml']) && !empty($xmls['respuesta-xml'])) {
                $xmlRespuestaHaciendaFactura = base64_decode($xmls['respuesta-xml']);
            }

            // Convertir xmlFirmado de base64 a XML
            if (isset($xmls['xmlFirmado']) && !empty($xmls['xmlFirmado'])) {
                $xmlFactura = base64_decode($xmls['xmlFirmado']);
            }
        }


        try {
            \Mail::to($emails)->send(new SendInvoice($pdf->output(), $xmlFactura, $xmlRespuestaHaciendaFactura, $invoice));

            if (request()->wantsJson()) {
                return response([], 200);
            }

        } catch (\Swift_TransportException $e) {  //Swift_RfcComplianceException
            if (request()->wantsJson()) {
                return response(['error'], 500);
            }
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ticket(Invoice $invoice)
    {
        //$invoice->load('lines.taxes', 'referencias');
        $invoice->load(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'referencias']);

        $formatLetras = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $TotalEnLetras = $formatLetras->format($invoice->TotalComprobante);
        $taxes = $this->getTaxes($invoice->lines);
        return view('invoices.ticket', compact('invoice','TotalEnLetras', 'taxes'));
        
    }

    private function getTaxes($lines)
    {
        $result = [];
        foreach ($lines as $line) {
            foreach ($line['taxes'] as $tax) {
                $codigo = $tax['code'] ?? '01';
                $tarifa = $tax['tarifa'] ?? '13';
                $monto = isset($tax['amount']) ? (float)$tax['amount'] : 0;
                $key = $codigo . '-' . $tarifa;

                if (!isset($result[$key])) {
                    $result[$key] = [
                        'Codigo' => $codigo,
                        'Tarifa' => $tarifa,
                        'TotalMontoImpuesto' => 0
                    ];
                }

                $result[$key]['TotalMontoImpuesto'] += $monto;
            }
        }

        // Formatear los montos
        foreach ($result as &$item) {
            $item['TotalMontoImpuesto'] = number_format($item['TotalMontoImpuesto'], 5, '.', '');
        }
        return array_values($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Invoice $invoice)
    {
        $invoice->update([
            'canceled' => 1,
            'TotalWithNota' => 0
        ]);

        flash('Factura Anulada', 'success');

        return back();
    }

    private function prepareData($data, $obligadoTributario = null)
    {

         $data['consecutivo'] = $obligadoTributario ? $this->crearConsecutivoHacienda($obligadoTributario, $data['TipoDocumento']) : $this->crearConsecutivo($data['TipoDocumento']);

        if ($obligadoTributario) {
            $data['obligado_tributario_id'] = $obligadoTributario->id;
            $data['sucursal'] = $obligadoTributario->sucursal;
            $data['pos'] = $obligadoTributario->pos;
            $data['fe'] = 1;
            $data['CodigoActividadEmisor'] = $obligadoTributario->CodigoActividad;
        }

        if($data['TipoDocumento'] != '01' && $data['TipoDocumento'] != '04'){
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
        //$setting = \App\Setting::first();

        $consecutivo_inicio = $this->setting ? $this->setting->consecutivo : 1;

        
        $consecutivo = Invoice::where('TipoDocumento', $tipoDocumento)->max('consecutivo');
       

        return ($consecutivo) ? $consecutivo += 1 : $consecutivo_inicio;
    }

    public function crearConsecutivoHacienda($obligadoTributario, $tipoDocumento)
    {
        //$setting = \App\Setting::first();

        $consecutivo_inicio = $this->setting ? $this->setting->consecutivo : 1;


        if ($tipoDocumento == '01') {
            $consecutivo_inicio = $obligadoTributario->consecutivo_inicio;
        }

        if ($tipoDocumento == '02') {
            $consecutivo_inicio = $obligadoTributario->consecutivo_inicio_ND;
        }

        if ($tipoDocumento == '03') {
            $consecutivo_inicio = $obligadoTributario->consecutivo_inicio_NC;
        }

        if ($tipoDocumento == '04') {
            $consecutivo_inicio = $obligadoTributario->consecutivo_inicio_tiquete;
        }

        $consecutivo = Invoice::where('obligado_tributario_id', $obligadoTributario->id)
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

    

}
