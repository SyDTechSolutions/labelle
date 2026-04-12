<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
   
    public function edit()
    {
        $setting = Setting::first();
        $this->authorize('update', $setting);

        $configFactura = $setting->getObligadoTributario();
        $activities = Activity::all();

        return view('settings.edit', compact('setting', 'configFactura', 'activities'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $this->authorize('update', $setting);
       
        $this->validate(request(), [
            'company' => 'required',
            'logo_path' => 'mimes:jpg,jpeg,bmp,png|max:1000'
        ]);

       

        $setting->fill(request()->all());
        $setting->save();

        if ($logo = request()->file('logo_path')) {
            $this->uploadPhoto($logo, $setting);
        }


        flash('Configuracion actualizada', 'success');

        return Redirect('/settings');
    }

    public function uploadPhoto($file, $setting)
    {
        $mimes = ['jpg', 'jpeg', 'bmp', 'png'];

        $ext = $file->guessClientExtension();

        if (in_array($ext, $mimes)) {

            $setting->update([
                "logo_path" => $file->store('logos', 'public')
            ]);
        }

        return $setting;
    }

    public function showInventarioCero()
    {
        if(!auth()->user()->hasRole('admin')){
            abort(403);
        }

        return view('settings.inventarioCero');
    }

    public function setInventarioCero()
    {
        if(!auth()->user()->hasRole('admin')){
            abort(403);
        }
        $this->validate(request(),[
            'password' => 'required'
        ]);

        if (! Hash::check(request('password'), Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        \DB::table('products')->update([
            'quantity' => 0
        ]);

        flash('El Inventario se ha puesto en cero', 'success');
        return redirect('/products');
    }
}
