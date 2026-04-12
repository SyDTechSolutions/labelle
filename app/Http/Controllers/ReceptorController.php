<?php 
namespace App\Http\Controllers;

use App\Exports\ReceptorViewExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Receptor;
use App\Services\MensajeReceptorService;
use App\Jobs\ProcessMensajesReceptor;
use App\Jobs\ProcessMensajeReceptor;
use Illuminate\Support\Carbon;

class ReceptorController extends Controller
{
    public function __construct(MensajeReceptorService $mensajeReceptorService)
    {
        $this->middleware('auth');
        $this->setting = \App\Setting::first();
        $this->mensajeReceptorService = $mensajeReceptorService;
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

        $obligadoTributario = $this->setting->getObligadoTributario();

        if (!$obligadoTributario) {
            return redirect('/');
        }

        $receptors = Receptor::where('obligado_tributario_id', $obligadoTributario->id)->search($search)->latest()->paginate(10);//auth()->user()->receptors()->search($search)->latest()->paginate(10);


        return view('receptors.index', compact('receptors', 'search'));

       
    }

    public function report()
    {
        $search['q'] = request('q');
        $search['start'] = request('start');
        $search['end'] = request('end');
        $search['condicion'] = request('condicion');
        $search['sent_to_hacienda'] = request('sent_to_hacienda');
        $search['status_fe'] = request('status_fe');

        $obligadoTributario = $this->setting->getObligadoTributario();

        $receptors = Receptor::where('obligado_tributario_id', $obligadoTributario->id)->search($search)->get();

        if(request('export')){
            return \Excel::download(new ReceptorViewExport($receptors), 'receptors.xlsx');
        }

        return view('reports.receptors.index', compact('receptors', 'search'));

       
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('receptors.create');
       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate(request(), [
            'Clave' => 'required|unique:receptors',
            'tipo_identificacion_emisor' => 'required',
            'NumeroCedulaEmisor' => 'required',
            'MontoTotalImpuesto' => 'required',
            'TotalFactura' => 'required',
            'tipo_identificacion_receptor' => 'required',
            'NumeroCedulaReceptor' => 'required',
            'Mensaje' => 'required',
            'DetalleMensaje' => 'nullable',
            'nombre_emisor' => 'nullable',
            'email_emisor' => 'nullable',
            'TipoDocumento' => 'nullable',
            'MedioPago' => 'nullable',
            'CondicionVenta' => 'nullable',
            'PlazoCredito' => 'nullable',
            'CodigoMoneda' => 'nullable'

        ]);
        
       

        $config = null;
            
        $config = $this->setting->getObligadoTributario();
           
        if (!existsCertFile($config)) {

            $errors = [
                'certificate' => ['Parece que no tienes el certificado de hacienda ATV instalado. Para poder continuar verfica este configurado correctamente']
            ];


            return response()->json(['errors' => $errors], 422, []);
        }

       

        $data = $this->prepareData(request()->all(), $config);

        $receptor = Receptor::create($data);
      
        if ($config && $receptor->status) {
           
            ProcessMensajeReceptor::dispatch($receptor);
            // $result = $this->mensajeReceptorService->sendDocument($receptor);

            // if (!$result) {
            //     $receptor->update([
            //         'sent_to_hacienda' => 1,
                    
            //     ]);

                
            // }
        }

        return $receptor;

    }

    

    public function sendHacienda(Receptor $receptor)
    {
        if ($this->comprobarRecepcion($receptor)) { //verificamos si ya fue enviado la factura y actualizamos status fe
            \Log::info('Mensaje Receptor ya habia sido enviado');
            return $receptor;
        }

        $result = $this->mensajeReceptorService->sendDocument($receptor);

        if (!$result) {
            $receptor->update([
                'sent_to_hacienda' => 1,
                'status' => 1
            ]);

            return $receptor;
        }

        return response(['message' => 'Error al enviar'], 422);
        
    }

    public function comprobarRecepcion(Receptor $receptor)
    {
        $config = $receptor->obligadoTributario;
        $clave = $receptor->Clave . '-' . $receptor->NumeroConsecutivoReceptor;
        $respHacienda = $this->mensajeReceptorService->recepcionDocument($clave);
        
        
        if (isset($respHacienda->{'ind-estado'})) {

            if ($receptor->status_fe != 'aceptado') {
                $receptor->status_fe = $respHacienda->{'ind-estado'};
            }

            if (isset($respHacienda->{'respuesta-xml'})) {
                $receptor->resp_hacienda = json_encode($this->mensajeReceptorService->decodeRespuestaXML($respHacienda->{'respuesta-xml'}));
            }

            $receptor->sent_to_hacienda = 1;
            $receptor->save();

            return true;
        }

        return false;
    }

    public function uploadXml()
    {


        $config = $this->setting->getObligadoTributario();
        
        $this->validate(request(), [
            'file' => 'required|max:5000',
        ]);

        $data = request()->all();
       
       
        $mimes = ['xml','text/xml', 'application/xml', 'text/plain'];
        $fileUploaded = 'error';

        if (request()->file('file')) {
            $file = request()->file('file');
            $name = $file->getClientOriginalName();
            $ext = $file->getMimeType();
        
            if (in_array($ext, $mimes)) {

                $fileUploaded = $file->storeAs('facturaelectronica/' . $config->id . '/receptor', $name, 'local');
           

                // $labresult->name = $onlyName . '.' . $ext;
                // $labresult->save();

                if (Storage::disk('local')->exists($fileUploaded)) {
                
                    $factura = Storage::get($fileUploaded);
                
                    $facturaXML = new \SimpleXMLElement($factura);

                    $file->storeAs('facturaelectronica/' . $config->id . '/receptor/previews', (string)$facturaXML->Clave.'.xml', 'local');
                
                    return json_encode($facturaXML);
                
                    
                }
            }
            
        }

        return $fileUploaded;
    }

    public function lote()
    {


        $config = $this->setting->getObligadoTributario();

        $this->validate(request(), [
            'files' => 'required|max:5000',
        ]);

        $data = request()->all();
        

        $mimes = ['xml', 'text/xml', 'application/xml', 'text/plain'];
        $fileUploaded = 'error';
            //dd($data['files']);
        if (isset($data['files'])) {
           

            foreach ($data['files'] as $index => $file) {


                $ext = $file->getMimeType();
                $name = $file->getClientOriginalName();

                if (in_array($ext, $mimes)) {


                    $fileUploaded = $file->storeAs('facturaelectronica/' . $config->id . '/receptor/lote', $name, 'local');

                    if (Storage::disk('local')->exists($fileUploaded)) {

                        $factura = Storage::get($fileUploaded);

                        $facturaXML = new \SimpleXMLElement($factura);
                        $dataR['FechaEmisionFactura'] = (string)$facturaXML->FechaEmision;
                        $dataR['Clave'] = (string)$facturaXML->Clave;
                        $dataR['NumeroConsecutivo'] = (string)$facturaXML->NumeroConsecutivo;
                        $dataR['tipo_identificacion_emisor'] = (string)$facturaXML->Emisor->Identificacion->Tipo;
                        $dataR['NumeroCedulaEmisor'] = (string)$facturaXML->Emisor->Identificacion->Numero;
                        $dataR['MontoTotalImpuesto'] = (string)$facturaXML->ResumenFactura->TotalImpuesto ? (string)$facturaXML->ResumenFactura->TotalImpuesto : 0;
                        $dataR['ExisteImpuesto'] = (string)$facturaXML->ResumenFactura->TotalImpuesto >= 0 ? 1 : 0;
                        $dataR['TotalFactura'] = (string)$facturaXML->ResumenFactura->TotalComprobante;

                            $dataR['tipo_identificacion_receptor'] = (string)$facturaXML->Receptor->Identificacion->Tipo ? (string)$facturaXML->Receptor->Identificacion->Tipo : '';
                            $dataR['NumeroCedulaReceptor'] = (string)$facturaXML->Receptor->Identificacion->Numero ? (string)$facturaXML->Receptor->Identificacion->Numero : '';

                        $dataR['nombre_emisor'] = (string)$facturaXML->Emisor->Nombre;
                        $dataR['email_emisor'] = (string)$facturaXML->Emisor->CorreoElectronico;
                        $dataR['TipoDocumento'] = substr((string)$facturaXML->NumeroConsecutivo, 8, 2);
                        $dataR['MedioPago'] = (string)$facturaXML->MedioPago;
                        $dataR['CondicionVenta'] = (string)$facturaXML->CondicionVenta;
                        $dataR['PlazoCredito'] = (string)$facturaXML->PlazoCredito;
                        $dataR['CodigoMoneda'] = (string)$facturaXML->ResumenFactura->CodigoTipoMoneda ? $facturaXML->ResumenFactura->CodigoTipoMoneda->CodigoMoneda : 'CRC';
                        $dataR['TipoCambio'] = (string)$facturaXML->ResumenFactura->CodigoTipoMoneda ? $facturaXML->ResumenFactura->CodigoTipoMoneda->TipoCambio : 1;
                        $dataR['status'] = 1;
                        
                        //$dataR['CodigoActividad'] = $config->CodigoActividad; // no es necesario por que preparedata lo asigna

                        $dataR['Mensaje'] = request('Mensaje');
                        $dataR['DetalleMensaje'] = request('DetalleMensaje');

                        if(request('CondicionImpuesto') == '01'){
                            $dataR['CondicionImpuesto'] = '01'; //genera credito IVA
                            $dataR['MontoTotalDeGastoAplicable'] = 0;
                            $dataR['MontoTotalImpuestoAcreditar'] = $dataR['MontoTotalImpuesto'];
                        }
                        if(request('CondicionImpuesto') == '04'){
                            $dataR['CondicionImpuesto'] = '04'; //Gasto corriente no genera crédito
                            $dataR['MontoTotalDeGastoAplicable'] = $dataR['TotalFactura'];
                            $dataR['MontoTotalImpuestoAcreditar'] = 0;
                        }

                        $dataR = $this->prepareData($dataR, $config);

                        if(!Receptor::where('Clave', $dataR['Clave'])->exists()){
                            $receptor = Receptor::create($dataR);

                            $file->storeAs('facturaelectronica/' . $config->id . '/receptor/previews', $receptor->Clave.'.xml', 'local');
                        }
                        
                        
                    }

                    
                }
            }

           // $this->sendMensajesLote();
           ProcessMensajesReceptor::dispatch();
        }

       

        return $fileUploaded;
    }


    public function xml(Receptor $receptor)
    {
        $this->authorize('view', $receptor);
        
        $config = $receptor->obligadoTributario;

       
        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/receptor/pos_' . $receptor->clave . '_signed.xml')) {
            flash('Archivo no encontrado', 'danger');

            return back();
        }

     
    }

    


    private function prepareData($data, $obligadoTributario)
    {

        $data['consecutivo'] = $this->crearConsecutivoHacienda($obligadoTributario);

        if ($obligadoTributario) {
            $data['obligado_tributario_id'] = $obligadoTributario->id;
            $data['sucursal'] = $obligadoTributario->sucursal;
            $data['pos'] = $obligadoTributario->pos;
            $data['CodigoActividad'] = $obligadoTributario->CodigoActividad;

           
        }else{
            $data['obligado_tributario_id'] = 0;
        }

        $data['FechaEmisionFactura'] = (isset($data['FechaEmisionFactura']) && $data['FechaEmisionFactura']) ? Carbon::parse($data['FechaEmisionFactura']) : null;

        if( isset($data['MedioPago']) ){ // por error si en la factura viene mas de un medio de pago
            if( is_array($data['MedioPago']) ){
                $data['MedioPago'] = $data['MedioPago'][0];
            }
        }
    
        $data['created_by'] = isset($data['created_by']) ? $data['created_by'] : auth()->id();
        
        return $data;
    }



    public function crearConsecutivoHacienda($obligadoTributario)
    {
       

        $consecutivo_inicio = 1;


        if ($obligadoTributario->consecutivo_inicio_receptor) {
            $consecutivo_inicio = $obligadoTributario->consecutivo_inicio_receptor;
        }


        $consecutivo = Receptor::where('obligado_tributario_id', $obligadoTributario->id)
                                ->where('sucursal', $obligadoTributario->sucursal ? $obligadoTributario->sucursal : 1)
                                ->where('pos', $obligadoTributario->pos ? $obligadoTributario->pos : 1)
                                ->where('status', 1)
                                ->max('consecutivo');


        return ($consecutivo) ? $consecutivo += 1 : $consecutivo_inicio;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receptor $receptor)
    {
        $this->authorize('delete', $receptor);

        $receptor->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return Redirect('/receptor/mensajes');
    }
}
