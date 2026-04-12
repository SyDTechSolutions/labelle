<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ProductProvider extends Model
{
    protected $guarded = ['lines'];


    public function scopeSearch($query, $search)
    {
        if (isset($search['q']) && $search['q']) {
            
           
        }

        if(isset($search['start']) && $search['start']){
            $start = new Carbon($search['start']);
            $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
            $end = new Carbon($end);

            $query = $query->where([
                ['created_at', '>=', $start],
                ['created_at', '<=', $end->endOfDay()]
            ]);
        }


        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lines()
    {
        return $this->hasMany(ProductProviderLine::class);
    }

    public function saveLines($items)
    {
       
       
        foreach ($items as $item) {

            $item = Arr::except($item, array('id', 'product_provider_id'));

           $this->lines()->create($item);
          

           

        }

        return $this;
    }

}
