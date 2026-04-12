<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['photo','taxes'];

    /**
     * Boot the product instance.
     */
    protected static function boot()
    {
        parent::boot();
        static::created(function ($product) {
            if(request('taxes')){
                $product->taxes()->sync(request('taxes'));
               
            }
            $product->calculatePriceWithTaxes();
        });

       
        
    }
    // protected $appends = ['PriceWithTaxes'];

    public function calculatePriceWithTaxes()
    {
        $montoTarifaTotal = 0;
  

        foreach ($this->taxes as $tax) {

        
            $montoTarifa = 0;

            $tarifa = $tax->tarifa / 100;
            $montoTarifa = ($this->price * $tarifa);
    

            $montoTarifaTotal += $montoTarifa;
           
        }

        $this->update([
            'priceWithTaxes' => $montoTarifaTotal ? ($this->price + $montoTarifaTotal) : $this->price,
            'taxesAmount' => $montoTarifaTotal,
        ]);
        // $priceWithTaxes = 0;
        // $montoTarifa = 0;

        // foreach ($this->taxes as $tax) {
        //     $tarifa = $tax->tarifa / 100;
        //     $montoTarifa += ($this->price * $tarifa);
        //     $priceWithTaxes += $this->price + $montoTarifa;
        // }

        // $this->update([
        //     'priceWithTaxes' => $priceWithTaxes ? $priceWithTaxes : $this->price,
        //     'taxesAmount' => $montoTarifa,
        // ]);
        
    }

    public function photo()
    {   
        return asset('storage/'. $this->photo_path);
    }

    public function scopeSearch($query, $search)
    {
        if (isset($search['q']) && $search['q']) {
            $searchWord = $search['q'];

            if($search['precision'] != 'preciso'){
                return $query->where(function ($query) use ($searchWord) {
                    $query->where('name', 'like', '%' . $searchWord . '%')
                        ->orWhere('code', 'like', '%' . $searchWord . '%')
                        ->orWhere('location', 'like', '%' . $searchWord . '%');
                });
            }else{
                return $query->where(function ($query) use ($searchWord) {
                    $query->where('name', $searchWord)
                        ->orWhere('code', $searchWord)
                        ->orWhere('location', $searchWord);
                });
            }
        }

        return $query;
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class);
    }

    /**
     * Determine if the user has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasTax($tax)
    {
        if ($tax instanceof Tax) {
            $tax =  $tax->code;
        }
      
        return $this->taxes->contains('code', $tax);
    }
}
