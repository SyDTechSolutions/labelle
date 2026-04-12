<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectronicInvoiceLinesTax extends Model
{
    protected $guarded = [];
    protected $table = 'electronic_invoice_line_taxes';
    public $timestamps = false;
    
    public function invoiceLine()
    {
        return $this->belongsTo(ElectronicInvoiceLines::class);
    }
}
