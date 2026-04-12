<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaPurchaseLineTax extends Model
{
    protected $guarded = [];
    protected $table = 'proforma_purchase_line_taxes';
    public $timestamps = false;
    
    public function proformaPurchaseLine()
    {
        return $this->belongsTo(ProformaPurchaseLine::class);
    }
}
