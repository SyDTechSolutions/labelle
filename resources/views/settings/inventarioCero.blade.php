@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="/inventariocero" method="POST" data-confirm="Estas Seguro? Esto pondra las unidades de todos los productos en cero">
                @csrf

               <div class="form-group">
                <label for="password">Contraseña de usuario</label>
                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="" >
                @if ($errors->has('password'))
                    <div class="error invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
            </div>
                <button class="btn btn-danger btn-lg">Ejecutar</button>
            </form>
        </div>
    </div>
</div>
@endsection