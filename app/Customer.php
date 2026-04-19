<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    protected $appends = ['available_credit'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'identificacion_cliente', 'identificacion');

    }
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('email2', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('phone2', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('identificacion', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    public function getAvailableCreditAttribute()
    {
        //Obtener las facturas a crédito hechas por el cliente
        $creditInvoices = $this->invoices()
        ->where('identificacion_cliente', $this->identificacion)
        ->where('CondicionVenta','02')
        ->where('cxc_pending_amount', '>', 0)
        ->get();

        //Sumar cuanto crédito ha usado el cliente
        $usedCredit = $creditInvoices->sum('cxc_pending_amount');

        //Calcular el crédito disponible
        return $this->credit_limit - $usedCredit;
    }
}
