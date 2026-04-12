<div class="form-group">
     <p><small>(*) Campos requeridos</small></p>
    <label for="dni">Identificacion*</label>
    <input type="text" class="form-control {{ $errors->has('dni') ? ' is-invalid' : '' }}" id="dni" name="dni" placeholder="" value="{{ isset($provider) ? $provider->dni : old('dni') }}">
    @if ($errors->has('dni'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('dni') }}</strong>
        </div>
    @endif
  </div>
<div class="form-group">
    <label for="name">Nombre*</label>
    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="" value="{{ isset($provider) ? $provider->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
    @endif
  </div>
<div class="form-group">
    <label for="email">Email*</label>
    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="" value="{{ isset($provider) ? $provider->email : old('email') }}">
    @if ($errors->has('email'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </div>
    @endif
  </div>

  <div class="form-group">
    <label for="phone">Teléfono*</label>
    <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" placeholder="" value="{{ isset($provider) ? $provider->phone : old('phone') }}">
    @if ($errors->has('phone'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('phone') }}</strong>
        </div>
    @endif
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
        
        <label for="provincia">Provincia*</label>
        <select class="form-control custom-select {{ $errors->has('provincia') ? ' is-invalid' : '' }}" name="provincia" id="provincia" required>
                <!-- <option value="">-- Selecciona un rol --</option> -->
        
        <option value="" style="color: #c3c3c3">Provincia</option>
        <option value="1" {{ isset($configFactura) ? ($configFactura->provincia == '1' ? 'selected' : '') : '' }}>San Jose</option>
        <option value="2" {{ isset($configFactura) ? ($configFactura->provincia == '2' ? 'selected' : '') : '' }}>Alajuela</option>
        <option value="3" {{ isset($configFactura) ? ($configFactura->provincia == '3' ? 'selected' : '') : '' }}>Cartago</option>
        <option value="4" {{ isset($configFactura) ? ($configFactura->provincia == '4' ? 'selected' : '') : '' }}>Heredia</option>
        <option value="5" {{ isset($configFactura) ? ($configFactura->provincia == '5' ? 'selected' : '') : '' }}>Guanacaste</option>
        <option value="6" {{ isset($configFactura) ? ($configFactura->provincia == '6' ? 'selected' : '') : '' }}>Puntarenas</option>
        <option value="7" {{ isset($configFactura) ? ($configFactura->provincia == '7' ? 'selected' : '') : '' }}>Limon</option>
        
        </select>
            
        @if ($errors->has('provincia'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('provincia') }}</strong>
            </div>
        @endif
            
    </div>
    <div class="form-group col-md-6">
    <label for="canton">Canton*</label>

    <select class="form-control custom-select" name="canton" id="canton" required>
        <option value="">Canton</option>

    </select>


    @if ($errors->has('canton'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('canton') }}</strong>
        </div>
    @endif

    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
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
    <div class="form-group col-md-6">
        <label for="barrio">Barrio</label>
    
         <select class="form-control custom-select" name="barrio" id="barrio">
            <option value="">Barrio</option>

        </select>
        
        
        @if ($errors->has('barrio'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('barrio') }}</strong>
            </div>
        @endif
        
    </div>
  </div>
  <div class="form-group">
    <label for="address">Dirección</label>
    <textarea name="address" id="address" cols="30" rows="3" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}">{{ isset($provider) ? $provider->address : old('address') }}
    </textarea>
    
    @if ($errors->has('address'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('address') }}</strong>
        </div>
    @endif
  </div>
  <div class="form-group">
    <label for="description">Descripción *</label>
        <textarea name="description" id="description" cols="30" rows="3" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ isset($provider) ? $provider->description : old('description') }}
    </textarea>
    
    @if ($errors->has('description'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('description') }}</strong>
        </div>
    @endif
  </div>
  
   @if(isset($provider))
        @can('update', $provider)
            <button type="submit" class="btn btn-primary">Guardar</button>
        @endcan
    @else 
        <button type="submit" class="btn btn-primary">Guardar</button>
    @endif
    <a href="/providers" class="btn btn-default"> Regresar</a>
