<div class="form-group">
            
        <label for="code">Código</label>
        <input type="text" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" id="code" name="code" placeholder="" value="{{ isset($currency) ? $currency->code : old('code') }}">
        @if ($errors->has('code'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('code') }}</strong>
            </div>
        @endif
            
</div>

 <div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="" value="{{ isset($currency) ? $currency->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
    @endif
  </div>
<div class="form-group">
    <label for="symbol">Simbolo</label>
   
       <input type="text" class="form-control {{ $errors->has('symbol') ? ' is-invalid' : '' }}" id="symbol" name="symbol" placeholder="$" value="{{ isset($currency) ? $currency->symbol : old('symbol') }}">
      
    
    @if ($errors->has('symbol'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('symbol') }}</strong>
        </div>
    @endif
    
  </div>
  <div class="form-group">
    <label for="exchange">Tipo de cambio</label>
   
       <input type="text" class="form-control {{ $errors->has('exchange') ? ' is-invalid' : '' }}" id="exchange" name="exchange" placeholder="" value="{{ isset($currency) ? $currency->exchange : old('exchange') }}">
      
    
    @if ($errors->has('exchange'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('exchange') }}</strong>
        </div>
    @endif
    
  </div>

  
   @if(isset($currency))
        @can('update', $currency)
            <button type="submit" class="btn btn-primary">Guardar</button>
        @endcan
    @else 
        <button type="submit" class="btn btn-primary">Guardar</button>
    @endif
    <a href="/currencies" class="btn btn-default"> Regresar</a>
