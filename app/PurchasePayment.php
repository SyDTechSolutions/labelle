<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    protected $guarded = [];
    protected $table = 'purchase_payments';
    protected $casts = [
        'amount' => 'float'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {

            $payment->purchase->calculatePendingAmount();


        });
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
