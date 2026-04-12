<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectronicInvoiceLines extends Model
{
    protected $guarded = ['taxes','existencias','cantFracc','product', 'overrideImp'];
    protected $table = 'electronic_invoice_lines';
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($line) {
            $line->taxes->each->delete();
        });

    }
    protected $casts = [
        'exo' => 'integer',
        'updateStock' => 'integer'
    ];

    public function invoice()
    {
        return $this->belongsTo(ElectronicInvoice::class);
    }

    public function taxes()
    {
        return $this->hasMany(ElectronicInvoiceLinesTax::class);
    }

    public function saveTaxes($items)
    {
       
        return $this->taxes()->createMany($items);
    }
}
