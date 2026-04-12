<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Purchase;

class SendPurchase extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;
    public $purchase;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf, Purchase $purchase)
    {
        $this->pdf = $pdf;
        $this->purchase = $purchase;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Factura de compra')->markdown('emails.purchases.send')
            ->attachData($this->pdf, 'purchase' . $this->purchase->consecutivo . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
    }
}
