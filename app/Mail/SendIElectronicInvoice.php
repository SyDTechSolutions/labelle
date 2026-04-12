<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ElectronicInvoice;

class SendIElectronicInvoice extends Mailable
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
    public function __construct($pdf, $xml, $xmlMensajeHacienda, ElectronicInvoice $invoice)
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
        if($this->xmlMensajeHacienda){
            return $this->subject('Factura')->markdown('emails.invoices.send')
                    ->attachData($this->pdf, 'invoice'. $this->invoice->consecutivo .'.pdf', [
                        'mime' => 'application/pdf',
                    ])
                    ->attachData($this->xml, 'pos_'. $this->invoice->clave_fe . '_signed.xml',[
                        'mime' => 'application/xml',
                    ])
                    ->attachData($this->xmlMensajeHacienda, 'pos_mensaje_hacienda_' . $this->invoice->clave_fe . '.xml', [
                        'mime' => 'application/xml',
                    ]);
        }else{
            return $this->subject('Factura')->markdown('emails.invoices.send')
                ->attachData($this->pdf, 'invoice' . $this->invoice->consecutivo . '.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->attachData($this->xml, 'pos_' . $this->invoice->clave_fe . '_signed.xml', [
                    'mime' => 'application/xml',
                ]);
        }
    }
}
