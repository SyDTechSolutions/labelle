<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function logo()
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : asset('img/logo-default.png');
    }

    public function configFactura()
    {
        return $this->hasOne(ConfigFactura::class);
    }

    public function getObligadoTributario()
    {
        $config = null;

        
        $config = $this->configFactura;
        
       
        return $config;
    }

}
