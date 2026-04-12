<?php

namespace App\Mail;

use App\ProformaPurchase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendProformaPurchase extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    public $proformapurchase;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf, ProformaPurchase $proformapurchase)
    {
        $this->pdf = $pdf;
        $this->proformapurchase = $proformapurchase;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Proforma de compra')->markdown('emails.proformaPurchases.send')
            ->attachData($this->pdf, 'proforma' . $this->proformapurchase->consecutivo . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
