<div class="form-row">
    <div class="form-group col-md-6">

        <label for="tipo_identificacion">Tipo de identificación</label>
        <select class="form-control custom-select {{ $errors->has('tipo_identificacion') ? ' is-invalid' : '' }}" name="tipo_identificacion" id="tipo_identificacion">
            <option value=""></option>
            <option value="01" {{ isset($customer) ? ($customer->tipo_identificacion == '01' ? 'selected' : '') : (old('tipo_identificacion') == '01' ? 'selected' : '') }}>Cédula Física</option>
            <option value="02" {{ isset($customer) ? ($customer->tipo_identificacion == '02' ? 'selected' : '') : (old('tipo_identificacion') == '02' ? 'selected' : '') }}>Cédula Jurídica</option>
            <option value="03" {{ isset($customer) ? ($customer->tipo_identificacion == '03' ? 'selected' : '') : (old('tipo_identificacion') == '03' ? 'selected' : '') }}>DIMEX</option>
            <option value="04" {{ isset($customer) ? ($customer->tipo_identificacion == '04' ? 'selected' : '') : (old('tipo_identificacion') == '04' ? 'selected' : '') }}>NITE</option>
        </select>

        @if ($errors->has('tipo_identificacion'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('tipo_identificacion') }}</strong>
        </div>
        @endif

    </div>
    <div class="form-group col-md-6">
        <label for="identificacion">Identificación</label>

        <input type="text" class="form-control {{ $errors->has('identificacion') ? ' is-invalid' : '' }}" id="identificacion" name="identificacion" placeholder="" value="{{ isset($customer) ? $customer->identificacion : old('identificacion') }}">


        @if ($errors->has('identificacion'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('identificacion') }}</strong>
        </div>
        @endif

    </div>
</div>
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="" value="{{ isset($customer) ? $customer->name : old('name') }}">
    @if ($errors->has('name'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('name') }}</strong>
    </div>
    @endif
</div>
<div class="form-row">

    <div class="form-group col-md-6">

        <label for="activity_code">Código de Actividad</label>

        <input type="text" class="form-control {{ $errors->has('activity_code') ? ' is-invalid' : '' }}" id="activity_code" name="activity_code" placeholder="" value="{{ isset($customer) ? $customer->activity_code : old('activity_code') }}">

        @if ($errors->has('activity_code'))

        <div class="error invalid-feedback">

            <strong>{{ $errors->first('activity_code') }}</strong>

        </div>

        @endif

    </div>

    <div class="form-group col-md-6">

        <label for="email">Email</label>

        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="" value="{{ isset($customer) ? $customer->email : old('email') }}">

        @if ($errors->has('email'))

        <div class="error invalid-feedback">

            <strong>{{ $errors->first('email') }}</strong>

        </div>

        @endif

    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="phone">Teléfono</label>
        <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" placeholder="" value="{{ isset($customer) ? $customer->phone : old('phone') }}">
        @if ($errors->has('phone'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('phone') }}</strong>
        </div>
        @endif
    </div>
    <div class="form-group col-md-6">
        <label for="phone">Teléfono 2</label>
        <input type="text" class="form-control {{ $errors->has('phone2') ? ' is-invalid' : '' }}" id="phone2" name="phone2" placeholder="" value="{{ isset($customer) ? $customer->phone2 : old('phone2') }}">
        @if ($errors->has('phone2'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('phone2') }}</strong>
        </div>
        @endif
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-4">
    
            <label for="provincia">Provincia</label>
            <select class="form-control custom-select {{ $errors->has('provincia') ? ' is-invalid' : '' }}" name="provincia" id="provincia" >
                    <!-- <option value="">-- Selecciona un rol --</option> -->
             
            <option value="" style="color: #c3c3c3">Provincia</option>
            <option value="1" {{ isset($customer) ? ($customer->provincia == '1' ? 'selected' : '') : '' }}>San Jose</option>
            <option value="2" {{ isset($customer) ? ($customer->provincia == '2' ? 'selected' : '') : '' }}>Alajuela</option>
            <option value="3" {{ isset($customer) ? ($customer->provincia == '3' ? 'selected' : '') : '' }}>Cartago</option>
            <option value="4" {{ isset($customer) ? ($customer->provincia == '4' ? 'selected' : '') : '' }}>Heredia</option>
            <option value="5" {{ isset($customer) ? ($customer->provincia == '5' ? 'selected' : '') : '' }}>Guanacaste</option>
            <option value="6" {{ isset($customer) ? ($customer->provincia == '6' ? 'selected' : '') : '' }}>Puntarenas</option>
            <option value="7" {{ isset($customer) ? ($customer->provincia == '7' ? 'selected' : '') : '' }}>Limon</option>
            
            </select>
                
            @if ($errors->has('provincia'))
                <div class="error invalid-feedback">
                    <strong>{{ $errors->first('provincia') }}</strong>
                </div>
            @endif
                
    </div>
    <div class="form-group col-md-4">
        <label for="canton">Canton</label>
    
         <select class="form-control custom-select" name="canton" id="canton" >
            <option value="">Canton</option>

        </select>
        
        
        @if ($errors->has('canton'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('canton') }}</strong>
            </div>
        @endif
        
    </div>
    
 
 
    <div class="form-group col-md-4">
        <label for="distrito">Distrito</label>
    
         <select class="form-control custom-select" name="distrito" id="distrito" >
            <option value="">Distrito</option>

        </select>
        
        
        @if ($errors->has('distrito'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('distrito') }}</strong>
            </div>
        @endif
        
    </div>
</div>
<div class="form-group">
    <label for="address">Dirección</label>
    <textarea name="address" id="address" cols="30" rows="3" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}">{{ isset($customer) ? $customer->address : old('address') }}
    </textarea>

    @if ($errors->has('address'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('address') }}</strong>
    </div>
    @endif
</div>

<div class="form-group">
    <label for="PorcentajeDescuento">% Descuento</label>
    <input type="text" class="form-control {{ $errors->has('PorcentajeDescuento') ? ' is-invalid' : '' }}" id="PorcentajeDescuento" name="PorcentajeDescuento" placeholder="" value="{{ isset($customer) ? $customer->PorcentajeDescuento : old('PorcentajeDescuento') }}">
    @if ($errors->has('PorcentajeDescuento'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('PorcentajeDescuento') }}</strong>
    </div>
    @endif
</div>

<div class="form-group">
    <label for="name">Categoria o tipo</label>
    <input type="text" class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" id="category" name="category" placeholder="" value="{{ isset($customer) ? $customer->category : old('category') }}">
    @if ($errors->has('category'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('category') }}</strong>
    </div>
    @endif
</div>

@if(isset($customer))
@can('update', $customer)
<button type="submit" class="btn btn-primary">Guardar</button>
@endcan
@else
<button type="submit" class="btn btn-primary">Guardar</button>
@endif
<a href="/customers" class="btn btn-default"> Regresar</a>