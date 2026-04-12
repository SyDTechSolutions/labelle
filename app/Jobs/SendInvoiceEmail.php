<?php

namespace App\Jobs;

use App\Invoice;
use App\Mail\SendInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoiceId;
    protected $emails;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invoiceId, $emails = null)
    {
        $this->invoiceId = $invoiceId;
        $this->emails = $emails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = Invoice::with(['lines' => function ($query) {
            $query->orderBy('id', 'asc');
        }, 'lines.taxes', 'creator'])->find($this->invoiceId);
        
        if (!$invoice) {
            return;
        }

        $pdf = \PDF::loadView('invoices.pdf', $invoice->toArray());
        $config = \App\ConfigFactura::first();

        $xmlFactura = null;
        $xmlRespuestaHaciendaFactura = null;

        if (Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml')) {
            $xmlFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_' . $invoice->clave_fe . '_signed.xml');
        }
        if (Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml')) {
            $xmlRespuestaHaciendaFactura = Storage::disk('local')->get('facturaelectronica/' . $config->id . '/pos_mensaje_hacienda_' . $invoice->clave_fe . '.xml');
        }

        $to = $invoice->email;

        if (!empty($to)) {
            Mail::to($to)->send(new SendInvoice($pdf->output(), $xmlFactura, $xmlRespuestaHaciendaFactura, $invoice));
        }
    }
}
