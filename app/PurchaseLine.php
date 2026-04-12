<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseLine extends Model
{
    protected $guarded = ['taxes','existencias','precio_con_descuento', 'product', 'overrideImp'];
    protected $table = 'purchase_lines';
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($line) {
            $line->taxes->each->delete();
        });

        static::creating(function ($line) {
           //\Log::info($line);
            $product = Product::where('code', $line->Codigo)->first();

            if($product && !$line->ingresado_inventario){
                
               
                $purchasePriceWithDiscount = $line->precioUnidad - ($line->precioUnidad * ($line->PorcentajeDescuento / 100));

                $price = roundM(($purchasePriceWithDiscount * ($line->utilidad / 100)) + $purchasePriceWithDiscount);
             
                if($product->purchase_price > $purchasePriceWithDiscount){ // si en la compra el producto es menor de lo que hay en el inventario dejar el que esta en el inventario
                    $purchasePriceWithDiscount = $product->purchase_price;
                    $price = $product->price;
                }
                
                $product->update([
                    'quantity' => $product->quantity + $line->unidades,
                    'purchase_price' => $purchasePriceWithDiscount,
                    'utilidad' => $line->utilidad,
                    'price' => $price,
            
                ]);
                
                $line->ingresado_inventario = 1;
               

                $product->calculatePriceWithTaxes();
            }
        });

    }
    protected $casts = [
       'exo' => 'integer',
       'updateStock' => 'integer'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function taxes()
    {
        return $this->hasMany(PurchaseLineTax::class);
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
       
        return $this->taxes()->createMany($items);;
    }
}
