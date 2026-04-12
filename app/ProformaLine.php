<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaLine extends Model
{
    protected $guarded = ['taxes','existencias','cantFracc', 'product', 'overrideImp'];
    protected $table = 'proforma_lines';

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

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    public function taxes()
    {
        return $this->hasMany(ProformaLineTax::class);
    }

    public function saveTaxes($items)
    {
       
        return $this->taxes()->createMany($items);;
    }
}
