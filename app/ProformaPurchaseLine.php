<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaPurchaseLine extends Model
{
    protected $guarded = ['taxes','existencias','precio_con_descuento', 'product', 'overrideImp', 'providers', 'provider_id'];
    protected $table = 'proforma_purchase_lines';
    
    protected $casts = [
       'exo' => 'integer',
       'updateStock' => 'integer'
    ];

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

    public function proformaPurchase()
    {
        return $this->belongsTo(ProformaPurchase::class);
    }

    public function taxes()
    {
        return $this->hasMany(ProformaPurchaseLineTax::class);
    }

    public function saveTaxes($items, $productCode = null)
    {
        if($productCode){

            $product = Product::where('code', $productCode)->first();

            if($product){

                $taxes = [];
                
                foreach($items as $taxLine)
                {
                    $tax = Tax::where('code', $taxLine['code'])->where('CodigoTarifa', $taxLine['CodigoTarifa'])->first();
                    $taxes[] = $tax->id;
                }
            
               
                $product->taxes()->sync($taxes);

                $product->calculatePriceWithTaxes();
                
            }

        }
       //dd($items);
        return $this->taxes()->createMany($items);
    }
}
