<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    protected $casts = [
        'amount' => 'float'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
           
            $payment->invoice->calculatePendingAmount();
            
          
        });
    }
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
