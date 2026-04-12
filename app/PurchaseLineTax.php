<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseLineTax extends Model
{
    protected $guarded = [];
    protected $table = 'purchase_line_taxes';
    public $timestamps = false;
    
    public function purchaseLine()
    {
        return $this->belongsTo(PurchaseLine::class);
    }
}
