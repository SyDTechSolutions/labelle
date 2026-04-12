<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Proforma;

class SendProforma extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    public $proforma;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf, Proforma $proforma)
    {
        $this->pdf = $pdf;
        $this->proforma = $proforma;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Proforma')->markdown('emails.proformas.send')
            ->attachData($this->pdf, 'proforma' . $this->proforma->consecutivo . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
