<?php

namespace App\Jobs;

use App\Invoice;
use App\Apis\Factura\Hacienda;
use App\Mail\SendInvoice;
use App\Services\FacturaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ValidarRespuestaHacienda implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoiceId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = Invoice::find($this->invoiceId);
        if (!$invoice) {
            return;
        }
        $attributes = $invoice->getAttributes();
        $hacienda = new Hacienda();
        $facturaService = app(FacturaService::class);
        $respHacienda = $hacienda->getXMLResponse($attributes['clave_fe'] ?? null);
        if (isset($respHacienda['ind-estado'])) {
            if (($attributes['status_fe'] ?? null) !== 'aceptado') {
                $invoice->status_fe = $respHacienda['ind-estado'];
            }

            if (isset($respHacienda['respuesta-xml'])) {
                $invoice->resp_hacienda = json_encode($facturaService->decodeRespuestaXML($respHacienda['respuesta-xml']));
            }
            
            $invoice->sent_to_hacienda = 1;
            $invoice->save();
        }
        // Decodificar y guardar XMLs en base64 si existen
        $clave_fe = $attributes['clave_fe'] ?? null;
        $config = $invoice->obligadoTributario;

        if (!empty($respHacienda['xmlFirmado'])) {
            $xmlFirmadoDecoded = base64_decode($respHacienda['xmlFirmado']);
            \Storage::put('facturaelectronica/1/pos_' . $clave_fe . '_signed.xml', $xmlFirmadoDecoded);
        }
        if (!empty($respHacienda['respuesta-xml'])) {
            $respuestaXmlDecoded = base64_decode($respHacienda['respuesta-xml']);
            \Storage::put('facturaelectronica/1/pos_mensaje_hacienda_' . $clave_fe . '_signed.xml', $respuestaXmlDecoded);
        }

        if(isset($respHacienda['ind-estado']) && $respHacienda['ind-estado'] === 'aceptado') {
            SendInvoiceEmail::dispatch($invoice->id);
        }
    }
}
