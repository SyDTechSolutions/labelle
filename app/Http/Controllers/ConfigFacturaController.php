<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\ConfigFactura;
use Illuminate\Support\Facades\Storage;
use App\Setting;
use Illuminate\Support\Facades\Validator;

class ConfigFacturaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
      
    }

    /**
     * Guardar paciente
     */
    public function store(Setting $setting)
    {

        // $this->validate(request(), [
        //     'nombre' => 'required',
        //     'tipo_identificacion' => 'required',
        //     'identificacion' => 'required',
        //     'sucursal' => 'required|numeric',
        //     'pos' => 'required|numeric',
        //     'provincia' => 'required',
        //     'canton' => 'required',
        //     'distrito' => 'required',
        //     'otras_senas' => 'required',
        //     'email' => 'required|email',
        //     'atv_user' => 'required',
        //     'atv_password' => 'required',
        //     'pin_certificado' => 'required',
        //     //'certificado' => 'required',
        // ]);

        $v = Validator::make(request()->all(), [
            'nombre' => 'required',
            'tipo_identificacion' => 'required',
            'identificacion' => 'required|numeric',
            'sucursal' => 'required|numeric',
            'pos' => 'required|numeric',
            'provincia' => 'required',
            'canton' => 'required',
            'distrito' => 'required',
            'otras_senas' => 'required',
            'email' => 'required|email',
            'atv_user' => 'required',
            'atv_password' => 'required',
            'pin_certificado' => 'required',
        ]);

        $v->sometimes('identificacion', 'digits:9', function ($input) {
            return $input->tipo_identificacion == '01';
        });

        $v->sometimes('identificacion', 'digits:10', function ($input) {
            return $input->tipo_identificacion == '02' || $input->tipo_identificacion == '04';
        });

        $v->sometimes('identificacion', 'digits_between:11,12', function ($input) {
            return $input->tipo_identificacion == '03';
        });

        $v->validate();


        $config = $setting->configFactura()->create(request()->all());

        $mimes = ['p12'];
        $fileUploaded = 'error';

        if (request()->file('certificado')) {
            $file = request()->file('certificado');

            $ext = $file->guessClientExtension();

            if (in_array($ext, $mimes)) {
                $fileUploaded = $file->storeAs('facturaelectronica/' . $config->id, 'cert.' . $ext, 'local');
            }
        }

        if (request()->file('certificado_test')) {
            $file = request()->file('certificado_test');

            $ext = $file->guessClientExtension();

            if (in_array($ext, $mimes)) {
                $fileUploaded = $file->storeAs('facturaelectronica/' . $config->id, 'test.' . $ext, 'local');
            }
        }

        flash('Configuracion de factura electronica Creada', 'success');

        return back();
    }

    /**
     * Actualizar Paciente
     */
    public function update(ConfigFactura $config)
    {
        $v = Validator::make(request()->all(), [
            'nombre' => 'required',
            'tipo_identificacion' => 'required',
            'identificacion' => 'required|numeric',
            'sucursal' => 'required|numeric',
            'pos' => 'required|numeric',
            'provincia' => 'required',
            'canton' => 'required',
            'distrito' => 'required',
            'otras_senas' => 'required',
            'email' => 'required|email',
            'atv_user' => 'required',
            'atv_password' => 'required',
            'pin_certificado' => 'required',
        ]);

        $v->sometimes('identificacion', 'digits:9', function ($input) {
            return $input->tipo_identificacion == '01';
        });

        $v->sometimes('identificacion', 'digits:10', function ($input) {
            return $input->tipo_identificacion == '02' || $input->tipo_identificacion == '04';
        });

        $v->sometimes('identificacion', 'digits_between:11,12', function ($input) {
            return $input->tipo_identificacion == '03';
        });

        $v->validate();

        $config->fill(request()->all());
        $config->save();

        $mimes = ['p12'];
        $fileUploaded = 'error';

        if (request()->file('certificado')) {
            $file = request()->file('certificado');

            $ext = $file->guessClientExtension();

            if (in_array($ext, $mimes)) {
                $fileUploaded = $file->storeAs('facturaelectronica/' . $config->id, 'cert.' . $ext, 'local');
            }
        }

        if (request()->file('certificado_test')) {
            $file = request()->file('certificado_test');

            $ext = $file->guessClientExtension();

            if (in_array($ext, $mimes)) {
                $fileUploaded = $file->storeAs('facturaelectronica/' . $config->id, 'test.' . $ext, 'local');
            }
        }

        flash('Configuracion de factura electronica Actualizada', 'success');

        return back();
    }

    /**
     * Eliminar consulta(cita)
     */
    public function destroy(ConfigFactura $config)
    {
        $this->authorize('update', $config);

        if (Storage::disk('local')->exists('facturaelectronica/' . $config->id . '/cert.p12')) {
            Storage::deleteDirectory('facturaelectronica/' . $config->id . '/');
        }

        $config->delete();

        flash('Configuracion Eliminada', 'success');

        return back();
    }

   
}
