<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
{
    protected $guarded = ['taxes','existencias','cantFracc','product', 'overrideImp'];
    protected $table = 'invoice_lines';
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($line) {
            $line->taxes->each->delete();
        });

        static::created(function ($line) {
            $invoice = $line->invoice;

            $product = Product::where('code', $line->Codigo)->first();

            if($product){

                if($invoice->TipoDocumento == '03' && $line->updateStock){

                    $quantity = $product->quantity + $line->Cantidad;
                    $product->update(['quantity' => $quantity]);
                   
                }
                if($invoice->TipoDocumento == '02' && $line->updateStock) {
                    
                    $quantity = $product->quantity - $line->Cantidad;
                    $quantity = $quantity < 0 ? 0 : $quantity;
                    $product->update(['quantity' => $quantity]);

                }
                if($invoice->TipoDocumento == '01' || $invoice->TipoDocumento == '04') {

                    $quantity = $product->quantity - $line->Cantidad;
                    $quantity = $quantity < 0 ? 0 : $quantity;
                    $product->update(['quantity' => $quantity]);
                }
               
    
            }



        });
    }
    protected $casts = [
        'exo' => 'integer',
        'updateStock' => 'integer'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function taxes()
    {
        return $this->hasMany(InvoiceLineTax::class);
    }

    public function exonerations()
    {
        return $this->hasOne(InvoiceLineExo::class);
    }

    public function saveTaxes($items)
    {
       
        return $this->taxes()->createMany($items);
    }

    
}
