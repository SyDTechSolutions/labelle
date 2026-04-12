<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Receptor extends Model
{
    protected $guarded = [];
    protected $appends = ['MensajeName'];
    public function getMensajeNameAttribute()
    {
        return trans('utils.tipo_mensaje_receptor.' . $this->Mensaje);
    }
    public function getTipoDocumentoNameAttribute()
    {
        return trans('utils.tipo_documento.' . $this->TipoDocumento);
    }

    public function getCondicionVentaNameAttribute()
    {
        return trans('utils.condicion_venta.' . $this->CondicionVenta);
    }

    public function scopeSearch($query, $search)
    {
        if (isset($search['q']) && $search['q']) {

            $query = $query->where(function ($query) use ($search) {
                $query->where('NumeroConsecutivoReceptor', 'like', '%' . $search['q'] . '%')
                    ->orWhere('NumeroCedulaEmisor', 'like', '%' . $search['q'] . '%')
                    ->orWhere('nombre_emisor', 'like', '%' . $search['q'] . '%')
                    ->orWhere('email_emisor', 'like', '%' . $search['q'] . '%')
                    ->orWhere('NumeroConsecutivo', 'like', '%' . $search['q'] . '%');
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

        if (isset($search['currency']) && $search['currency']) {

            $query = $query->where('CodigoMoneda', $search['currency']);
        }

        if (isset($search['type']) && $search['type']) {

            $query = $query->where('TipoDocumento', $search['type']);
        }
        if (isset($search['condicion']) && $search['condicion']) {

            $query = $query->where('CondicionVenta', $search['condicion']);


        }

        if (isset($search['sent_to_hacienda']) && !is_blank($search['sent_to_hacienda'])) {

            $query = $query->where('sent_to_hacienda', $search['sent_to_hacienda']);
                   
           
        }
        if (isset($search['status_fe']) && $search['status_fe']) {

            $query = $query->where('status_fe', $search['status_fe']);


        }
        

        return $query;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function obligadoTributario()
    {
        return $this->belongsTo(ConfigFactura::class, 'obligado_tributario_id');
    }
}
