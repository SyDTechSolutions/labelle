<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLineTax extends Model
{
    protected $guarded = ['proforma_line_id'];

    protected $fillable = [
        'code',
        'CodigoTarifa',
        'name',
        'tarifa',
        'amount',
        'TipoDocumento',
        'NumeroDocumento',
        'NombreInstitucion',
        'FechaEmision',
        'PorcentajeExoneracion',
        'MontoExoneracion',
        'TarifaOriginal',
        'ImpuestoOriginal',
        'ImpuestoNeto'
    ];
    
    protected $table = 'invoice_line_taxes';
    public $timestamps = false;
    
    public function invoiceLine()
    {
        return $this->belongsTo(InvoiceLine::class);
    }
}
