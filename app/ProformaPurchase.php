<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class ProformaPurchase extends Model
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
                    ->orWhere('consecutivo', 'like', '%' . $search['q'] . '%')
                    ->orWhere('factura_proveedor', 'like', '%' . $search['q'] . '%');
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


        return $query;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function lines()
    {
        return $this->hasMany(ProformaPurchaseLine::class);
    }


    public function saveLines($items)
    {


        foreach ($items as $item) {

            $item = Arr::except($item, array('id', 'proforma_purchase_id', 'product_provider_id', 'providers'));

            $line = $this->lines()->create($item);
            $line->saveTaxes($item['taxes']);


        }

        return $this;
    }

    
}
