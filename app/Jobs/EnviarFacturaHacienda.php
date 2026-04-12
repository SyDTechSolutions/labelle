<?php

namespace App\Jobs;

use App\Invoice;
use App\Apis\Factura\Hacienda;
use App\ConfigFactura;
use App\Jobs\ValidarRespuestaHacienda;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarFacturaHacienda implements ShouldQueue
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
        $setting = \App\Setting::first();
        $config = ConfigFactura::first();
        if ($setting && $setting->fe) {
            $hacienda = new Hacienda();
            $result = $hacienda->sendDocument($invoice);
            $consecutivo = substr($result['clave'], 21, 20); // Extrae los 20 caracteres del consecutivo

            if ($result) {
                $invoice->update([
                    'NumeroConsecutivo' => $consecutivo,
                    'clave_fe' => $result['clave'],
                    'status_fe'=> $result['ind-estado'],
                    'created_xml' => 1,
                    'fe'=>1,
                    'resp_hacienda' => json_encode($result),
                    'obligado_tributario_id' => $config->id
                ]);
                ValidarRespuestaHacienda::dispatch($invoice->id);
            }
        }
    }
}
