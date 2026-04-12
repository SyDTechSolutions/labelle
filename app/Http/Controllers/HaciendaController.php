<?php

namespace App\Http\Controllers;

use App\Apis\Factura\Hacienda;
use Illuminate\Http\Request;
use App\Invoice;
use App\ElectronicInvoice;
use App\User;
use App\Notifications\HaciendaNotification;
use Illuminate\Support\Facades\Storage;
use App\Receptor;
use App\Mail\SendInvoice;
use App\Mail\SendIElectronicInvoice;
use App\Services\FacturaService;
use App\Services\FacturaElectronicaService;


class HaciendaController extends Controller
{
    public function __construct(FacturaService $facturaService, FacturaElectronicaService $facturaElectronic)
    {
        //$this->middleware('auth');
        $this->setting = \App\Setting::first();
        $this->facturaService = $facturaService;
        $this->facturaElectronic = $facturaElectronic;
    }


    public function recepcion(Invoice $invoice)
    {

        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $hacienda = new Hacienda();
        $respHacienda = $hacienda->getXMLResponse($clave ?? null);

        if (isset($respHacienda['ind-estado'])) {

            if($invoice->status_fe != 'aceptado'){
                $invoice->status_fe = $respHacienda['ind-estado'];
            }

            if (isset($respHacienda['respuesta-xml'])) {
                $invoice->resp_hacienda = json_encode($this->facturaService->decodeRespuestaXML($respHacienda['respuesta-xml']));
            }

            $invoice->save();
        }else{
            return response(['errors' => $respHacienda], 400);
        }

        return $invoice;
    }

    public function recepcionCompra(ElectronicInvoice $invoice)
    {

        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $respHacienda = $this->facturaElectronic->recepcionDocument($clave);

        $this->saveRespuestaXML($config, $clave, $respHacienda);


        if (isset($respHacienda->{'ind-estado'})) {

            if($invoice->status_fe != 'aceptado'){
                $invoice->status_fe = $respHacienda->{'ind-estado'};
            }

            if (isset($respHacienda->{'respuesta-xml'})) {
                $invoice->resp_hacienda = json_encode($this->facturaElectronic->decodeRespuestaXML($respHacienda->{'respuesta-xml'}));
            }

            $invoice->save();
        }else{
            return response(['errors' => $respHacienda], 400);
        }

        return $invoice;
    }

    public function xml(Invoice $invoice)
    {


        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $respHacienda = $this->facturaService->recepcionDocument($clave);

        $this->saveRespuestaXML($config, $clave, $respHacienda);


        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml')) {
            flash('Archivo no encontrado', 'danger');

            return back();
        }

        return Storage::disk('local')->download('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml');

       // return response()->download($pathToFile);
    }

    public function xmlCompra(ElectronicInvoice $invoice)
    {


        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $respHacienda = $this->facturaElectronic->recepcionDocument($clave);

        $this->saveRespuestaXML($config, $clave, $respHacienda);


        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml')) {
            flash('Archivo no encontrado', 'danger');

            return back();
        }

        return Storage::disk('local')->download('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml');

       // return response()->download($pathToFile);
    }

    public function recepcionMensaje(Receptor $receptor)
    {
        
        $config = $receptor->obligadoTributario;
        $clave = $receptor->Clave.'-'. $receptor->NumeroConsecutivoReceptor;
        $respHacienda = $this->facturaService->recepcionDocument($clave); //$this->feRepo->recepcion($config, $receptor->Clave.'-'. $receptor->NumeroConsecutivoReceptor);
        //dd($respHacienda);

        $this->saveRespuestaXML($config, $clave, $respHacienda);

        if (isset($respHacienda->{'ind-estado'})) {

            if($receptor->status_fe != 'aceptado'){
                $receptor->status_fe = $respHacienda->{'ind-estado'};
            }
           
            if (isset($respHacienda->{'respuesta-xml'})) {
                $receptor->resp_hacienda = json_encode($this->facturaService->decodeRespuestaXML($respHacienda->{'respuesta-xml'}));
            }

            $receptor->save();
        }else{
            return response(['errors' => $respHacienda], 400);
        }

        return $receptor;
    }
    public function xmlMensaje(Receptor $receptor)
    {


        $config = $receptor->obligadoTributario;
        $clave = $receptor->Clave.'-'. $receptor->NumeroConsecutivoReceptor;
        // $respHacienda = $this->feRepo->recepcion($config, $invoice->clave_fe);

        // Storage::put('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml', base64_decode($respHacienda->{'respuesta-xml'}));


        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml')) {
            flash('Archivo no encontrado', 'danger');

            return back();
        }

        return Storage::disk('local')->download('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml');

       // return response()->download($pathToFile);
    }

    public function recepcionClave($clave)
    {

        $config = $this->setting->getObligadoTributario();

        $respHacienda = $this->facturaService->recepcionDocument($clave);

        return json_encode($this->facturaService->decodeRespuestaXML($respHacienda->{'respuesta-xml'}));

    }

    // public function comprobante($clave)
    // {


    //     $result = $this->feRepo->comprobante($this->setting->getObligadoTributario(), $clave);

    //     return $result;
    // }

    public function haciendaResponse()
    {
        $resp = request()->all();

        \Log::info('results of Hacienda: Clave: ' . $resp['clave'].', fecha: ' . $resp['fecha']. ', estado: ' . $resp['ind-estado']);

        $invoice = Invoice::where('clave_fe', $resp['clave'])->first();



        if (!$invoice) {
            $invoice = ElectronicInvoice::where('clave_fe', $resp['clave'])->first();
            if (!$invoice) {
                return false;
            }
        }

        $invoice->status_fe = $resp['ind-estado'];
        $invoice->sent_to_hacienda = 1;
        $invoice->save();

        if ($resp['ind-estado'] != 'aceptado') {

            $user = User::find($invoice->created_by);

            if ($user) {
                $user->notify(new HaciendaNotification($invoice, $resp['ind-estado']));
            }


        }

        if($resp['ind-estado'] == 'aceptado'){
            if($invoice->TipoDocumento == '08'){
                $this->sendCompraEmailReceptor($invoice);
            }else{  
                $this->sendEmailReceptor($invoice);
            }

        }
    }

    public function haciendaMensajeResponse()
    {
        $resp = request()->all();

        //\Log::info('results of Hacienda: ' . json_encode($resp));

        $receptor = Receptor::where('Clave_Mensaje', $resp['clave'])->first();



        if (!$receptor) {
            return false;
        }

        $receptor->status_fe = $resp['ind-estado'];
        $receptor->sent_to_hacienda = 1;
        $receptor->save();

        // if ($resp['ind-estado'] != 'aceptado') {

        //     $user = User::find($receptor->created_by);

        //     if ($user) {
        //         $user->notify(new HaciendaNotification($receptor, $resp['ind-estado']));
        //     }
            

        // }
    }

    public function saveRespuestaXML($config, $clave, $respHacienda)
    {
        if (isset($respHacienda->{'respuesta-xml'})) {
            Storage::put('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml', base64_decode($respHacienda->{'respuesta-xml'}));
        }
    }

    public function sendEmailReceptor(Invoice $invoice)
    {
        if(!$invoice->email){ return false; }

        $invoice->load('lines.taxes');

        $pdf = \PDF::loadView('invoices.pdf', $invoice->toArray());

        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $respHacienda = $this->facturaService->recepcionDocument($clave);

        $this->saveRespuestaXML($config, $clave, $respHacienda);

        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_' . $clave . '_signed.xml')) {
            //flash('Archivo XML no encontrado', 'danger');

            if (request()->wantsJson()) {
                return response('Archivo XML no encontrado', 404);
            }
        }

        $xmlFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_' . $clave . '_signed.xml');

        $xmlRespuestaHaciendaFactura = null;

        if (Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml')) {

            $xmlRespuestaHaciendaFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml');
        }


        try {
            \Mail::to($invoice->email)->send(new SendInvoice($pdf->output(), $xmlFactura, $xmlRespuestaHaciendaFactura, $invoice));

            if (request()->wantsJson()) {
                return response([], 200);
            }

        } catch (\Swift_TransportException $e) {  //Swift_RfcComplianceException
            if (request()->wantsJson()) {
                return response(['error'], 500);
            }
        }
    }

    public function sendCompraEmailReceptor(ElectronicInvoice $invoice)
    {
        if(!$invoice->email){ return false; }

        $invoice->load('lines.taxes');

        $pdf = \PDF::loadView('electronicInvoice.pdf', $invoice->toArray());

        $config = $invoice->obligadoTributario;
        $clave = $invoice->clave_fe;
        $respHacienda = $this->facturaElectronic->recepcionDocument($clave);

        $this->saveRespuestaXML($config, $clave, $respHacienda);

        if (!Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_' . $clave . '_signed.xml')) {
            //flash('Archivo XML no encontrado', 'danger');

            if (request()->wantsJson()) {
                return response('Archivo XML no encontrado', 404);
            }
        }

        $xmlFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_' . $clave . '_signed.xml');

        $xmlRespuestaHaciendaFactura = null;

        if (Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml')) {

            $xmlRespuestaHaciendaFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $clave . '.xml');
        }


        try {
            \Mail::to($invoice->email)->send(new SendIElectronicInvoice($pdf->output(), $xmlFactura, $xmlRespuestaHaciendaFactura, $invoice));

            if (request()->wantsJson()) {
                return response([], 200);
            }

        } catch (\Swift_TransportException $e) {  //Swift_RfcComplianceException
            if (request()->wantsJson()) {
                return response(['error'], 500);
            }
        }
    }


}
