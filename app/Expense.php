<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Expense extends Model
{
    protected $guarded = ['MedioPagoName'];
    protected $casts = [
        'amount' => 'float'
    ];
    protected $appends = ['MedioPagoName'];

    public function getMedioPagoNameAttribute()
    {
        return trans('utils.medio_pago.' . $this->MedioPago);
    }

    public function scopeSearch($query, $search)
    {
        if (isset($search['q']) && $search['q']) {

            $query = $query->where(function ($query) use ($search) {
                $query->where('referencia', 'like', '%' . $search['q'] . '%')
                    ->orWhere('observations', 'like', '%' . $search['q'] . '%');
                   
            });
        }

        if (isset($search['start']) && $search['start']) {
            $start = new Carbon($search['start']);
            $start = $start->startOfDay();
            $end = (isset($search['end']) && $search['end'] != "") ? $search['end'] : $search['start'];
            $end = new Carbon($end);
            $end = $end->endOfDay();

            $query = $query->where([
                ['date', '>=', $start],
                ['date', '<=', $end]
            ]);
        }

        if (isset($search['date']) && $search['date']) {
            $start = new Carbon($search['date']);
            $start = $start->startOfDay();
            $end = (isset($search['date']) && $search['date'] != "") ? $search['date'] : $search['date'];
            $end = new Carbon($end);
            $end = $end->endOfDay();

            $query = $query->where([
                ['date', '>=', $start],
                ['date', '<=', $end]
            ]);
        }

        if (isset($search['fromCierre']) && $search['fromCierre']) {

            $query = $query->where('fromCierre', $search['fromCierre']);


        }
        if (isset($search['MedioPago']) && $search['MedioPago']) {

            $query = $query->where('MedioPago', $search['MedioPago']);


        }
       


        return $query;
    }
   
}
