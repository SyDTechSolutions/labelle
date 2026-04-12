<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductProviderLine extends Model
{
    protected $guarded = ['existencias'];

    public function setProvidersAttribute($value)
    {
        $data = serialize($value);

        $this->attributes['providers'] = $data;
    }
    public function getProvidersAttribute($value)
    {
        
        return unserialize($value);
    }

    public function productProvider()
    {
        return $this->belongsTo(ProductProvider::class);
    }
}
