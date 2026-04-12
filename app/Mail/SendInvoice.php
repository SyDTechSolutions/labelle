<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Invoice;

class SendInvoice extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    protected $xml;
    protected $xmlMensajeHacienda;
    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf, $xml, $xmlMensajeHacienda, Invoice $invoice)
    {
        $this->pdf = $pdf;
        $this->invoice = $invoice;
        $this->xml = $xml;
        $this->xmlMensajeHacienda = $xmlMensajeHacienda;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->subject('Factura')->markdown('emails.invoices.send')
                    ->attachData($this->pdf, 'invoice'. $this->invoice->consecutivo .'.pdf', [
                        'mime' => 'application/pdf',
                    ]);

        // Solo adjuntar XML de factura si existe
        if($this->xml){
            $message->attachData($this->xml, 'pos_'. $this->invoice->clave_fe . '_signed.xml',[
                'mime' => 'application/xml',
            ]);
        }

        // Solo adjuntar XML de respuesta de Hacienda si existe
        if($this->xmlMensajeHacienda){
            $message->attachData($this->xmlMensajeHacienda, 'pos_mensaje_hacienda_' . $this->invoice->clave_fe . '.xml', [
                'mime' => 'application/xml',
            ]);
        }

        return $message;
    }
}
