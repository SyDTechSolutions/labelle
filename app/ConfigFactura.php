<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigFactura extends Model
{
    protected $fillable = ['nombre', 'nombre_comercial', 'tipo_identificacion', 'identificacion', 'sucursal', 'pos', 'codigo_pais_tel', 'telefono', 'codigo_pais_fax', 'fax', 'provincia', 'canton', 'distrito', 'barrio', 'otras_senas', 'email', 'consecutivo_inicio', 'atv_user', 'atv_password', 'pin_certificado', 'consecutivo_inicio_ND', 'consecutivo_inicio_NC', 'grant_type', 'access_token', 'refresh_token', 'token_expires_at','refresh_expires_at','CodigoActividad','consecutivo_inicio_tiquete','consecutivo_inicio_receptor','consecutivo_inicio_EI'];
    protected $table = 'config_facturas';
    public $timestamps = false;

    protected $hidden = [
        'atv_user', 'atv_password', 'pin_certificado', 'access_token', 'refresh_token', 'token_expires_at','refresh_expires_at'
    ];

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
