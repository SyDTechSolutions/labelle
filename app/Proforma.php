<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Proforma extends Model
{
    protected $guarded = ['lines', 'TipoDocumentoName', 'CondicionVentaName', 'MedioPagoName', 'Pending', 'initialPayment', 'payments'];

    protected $appends = ['TipoDocumentoName', 'CondicionVentaName', 'MedioPagoName'];

    protected $casts = [
        'status' => 'integer',
    ];
    
    public function getTipoDocumentoNameAttribute()
    {
        return trans('utils.tipo_documento.' . $this->TipoDocumento);
    }
    public function getCondicionVentaNameAttribute()
    {
        return trans('utils.condicion_venta.' . $this->CondicionVenta);
    }
    public function getMedioPagoNameAttribute()
    {
        return trans('utils.medio_pago.' . $this->MedioPago);
    }

    public function scopeSearch($query, $search)
    {
        if (isset($search['q']) && $search['q']) {

            $query = $query->where(function ($query) use ($search) {
                $query->where('cliente', 'like', '%' . $search['q'] . '%')
                    ->orWhere('consecutivo', 'like', '%' . $search['q'] . '%');
            });
        }

        if (isset($search['start']) && $search['start']) {
            $start = new Carbon($search['start']);
            $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
            $end = new Carbon($end);

            $query = $query->where([
                ['created_at', '>=', $start],
                ['created_at', '<=', $end->endOfDay()]
            ]);
        }

        if (isset($search['type']) && $search['type']) {

            $query = $query->where('TipoDocumento', $search['type']);


        }
        if (isset($search['condicion']) && $search['condicion']) {

            $query = $query->where('CondicionVenta', $search['condicion']);


        }
        if (isset($search['created_by']) && $search['created_by']) {

            $query = $query->where('created_by', $search['created_by']);


        }


        return $query;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lines()
    {
        return $this->hasMany(ProformaLine::class);
    }
   




    public function saveLines($items)
    {


        foreach ($items as $item) {

            $item = Arr::except($item, array('id', 'proforma_id'));

            $line = $this->lines()->create($item);
            $line->saveTaxes($item['taxes']);


        }

        return $this;
    }

   
}
