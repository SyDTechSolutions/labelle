<div class="form-group">
            
        <!-- <label for="nombre">Codigo Actividad*</label>
        <input type="text" class="form-control {{ $errors->has('CodigoActividad') ? ' is-invalid' : '' }}" id="CodigoActividad" name="CodigoActividad" placeholder="" value="{{ isset($configFactura) ? $configFactura->CodigoActividad : old('CodigoActividad') }}" required> -->
        <label for="CodigoActividad">Codigo Actividad*</label>
            <select class="form-control custom-select {{ $errors->has('CodigoActividad') ? ' is-invalid' : '' }}" name="CodigoActividad" id="CodigoActividad" >
                <option value=""></option>
                @foreach($activities as $activity)
                <option value="{{ $activity->codigo }}" {{ isset($configFactura) ? ($configFactura->CodigoActividad == $activity->codigo ? 'selected' : '') : '' }}>{{ $activity->codigo }} - {{ $activity->actividad }}</option>
                @endforeach
            </select>
        @if ($errors->has('CodigoActividad'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('CodigoActividad') }}</strong>
            </div>
        @endif
            
</div>
<div class="form-group">
            
        <label for="nombre">Nombre o Razón social del emisor*</label>
        <input type="text" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" id="nombre" name="nombre" placeholder="" value="{{ isset($configFactura) ? $configFactura->nombre  : (isset($setting->company) ? $setting->company : old('nombre')) }}" required>
        @if ($errors->has('nombre'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('nombre') }}</strong>
            </div>
        @endif
            
</div>

 <div class="form-group">
    <label for="ide">Nombre Comercial</label>
    <input type="text" class="form-control {{ $errors->has('nombre_comercial') ? ' is-invalid' : '' }}" id="nombre_comercial" name="nombre_comercial" placeholder="" value="{{ isset($configFactura) ? $configFactura->nombre_comercial : old('nombre_comercial') }}">
    @if ($errors->has('nombre_comercial'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('nombre_comercial') }}</strong>
        </div>
    @endif
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
    
            <label for="tipo_identificacion">Tipo de identificación</label>
            <select class="form-control custom-select {{ $errors->has('tipo_identificacion') ? ' is-invalid' : '' }}" name="tipo_identificacion" id="tipo_identificacion" >
                <option value=""></option>
                <option value="01" {{ isset($configFactura) ? ($configFactura->tipo_identificacion == '01' ? 'selected' : '') : '' }}>Cédula Física</option>
            <option value="02" {{ isset($configFactura) ? ($configFactura->tipo_identificacion == '02' ? 'selected' : '') : '' }}>Cédula Jurídica</option>
            <option value="03" {{ isset($configFactura) ? ($configFactura->tipo_identificacion == '03' ? 'selected' : '') : '' }}>DIMEX</option>
            <option value="04" {{ isset($configFactura) ? ($configFactura->tipo_identificacion == '04' ? 'selected' : '') : '' }}>NITE</option>
            </select>
                
            @if ($errors->has('tipo_identificacion'))
                <div class="error invalid-feedback">
                    <strong>{{ $errors->first('tipo_identificacion') }}</strong>
                </div>
            @endif
                
    </div>
    <div class="form-group col-md-6">
        <label for="identificacion">Identificación</label>
    
        <input type="text" class="form-control {{ $errors->has('identificacion') ? ' is-invalid' : '' }}" id="identificacion" name="identificacion" placeholder="" value="{{ isset($configFactura) ? $configFactura->identificacion : old('identificacion') }}">
        
        
        @if ($errors->has('identificacion'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('identificacion') }}</strong>
            </div>
        @endif
        
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
        <label for="sucursal">Sucursal</label>
        <input type="number"
                class="form-control {{ $errors->has('sucursal') ? ' is-invalid' : '' }}" id="sucursal"
                name="sucursal" 
                placeholder="" 
                value="{{ isset($configFactura) ? $configFactura->sucursal : old('sucursal','1') }}" required min="1"
                >
        @if ($errors->has('sucursal'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('sucursal') }}</strong>
            </div>
        @endif
    </div>
    <div class="form-group col-md-6">
        <label for="pos">Numero de Caja</label>
        <input type="number"
                class="form-control {{ $errors->has('pos') ? ' is-invalid' : '' }}" id="pos"
                name="pos" 
                placeholder="" 
                value="{{ isset($configFactura) ? $configFactura->pos : old('pos','1') }}" required min="1"
                >
        @if ($errors->has('pos'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('pos') }}</strong>
            </div>
        @endif
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
    
            <label for="provincia">Provincia</label>
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
        <label for="canton">Canton</label>
    
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
    
         <select class="form-control custom-select" name="distrito" id="distrito" required>
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
   <div class="form-group ">
    <label for="otras_senas">Otras señas</label>
   
       <input type="text" class="form-control {{ $errors->has('otras_senas') ? ' is-invalid' : '' }}" id="otras_senas" name="otras_senas" placeholder="" value="{{ isset($configFactura) ? $configFactura->otras_senas : old('otras_senas') }}">
      
    
    @if ($errors->has('otras_senas'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('otras_senas') }}</strong>
        </div>
    @endif
    
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
        <label for="codigo_pais_tel">Código Teléfono</label>

        <select class="form-control custom-select {{ $errors->has('codigo_pais_tel') ? ' is-invalid' : '' }}" name="codigo_pais_tel" id="codigo_pais_tel" >
            
                <option value="506" {{ isset($configFactura) ? ($configFactura->codigo_pais_tel == '506' ? 'selected' : '') : '' }}>+506</option>
            
        </select>
        
        @if ($errors->has('codigo_pais_tel'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('codigo_pais_tel') }}</strong>
            </div>
        @endif
        
    </div>
    <div class="form-group col-md-6">
        <label for="telefono">Teléfono</label>
    
        <input type="text" class="form-control {{ $errors->has('telefono') ? ' is-invalid' : '' }}" id="telefono" name="telefono" placeholder="" value="{{ isset($configFactura) ? $configFactura->telefono : old('telefono') }}">
        
        
        @if ($errors->has('telefono'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('telefono') }}</strong>
            </div>
        @endif
        
    </div>
    
 </div> 
 <div class="form-row">
    <div class="form-group col-md-6">
        <label for="codigo_pais_fax">Código Fax</label>
    
        <select class="form-control custom-select {{ $errors->has('codigo_pais_fax') ? ' is-invalid' : '' }}" name="codigo_pais_fax" id="codigo_pais_fax" >
               
                <option value="506" {{ isset($configFactura) ? ($configFactura->codigo_pais_fax == '506' ? 'selected' : '') : '' }}>+506</option>
            
        </select>
        
        @if ($errors->has('codigo_pais_fax'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('codigo_pais_fax') }}</strong>
            </div>
        @endif
        
    </div>
    <div class="form-group col-md-6">
        <label for="fax">Fax</label>
    
        <input type="text" class="form-control {{ $errors->has('fax') ? ' is-invalid' : '' }}" id="fax" name="fax" placeholder="" value="{{ isset($configFactura) ? $configFactura->fax : old('fax') }}">
        
        
        @if ($errors->has('fax'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('fax') }}</strong>
            </div>
        @endif
        
    </div>
 </div>
 
  <div class="form-group">
    <label for="email">Correo</label>
   
       <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="" value="{{ isset($configFactura) ? $configFactura->email : old('email') }}">
      
    
    @if ($errors->has('email'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </div>
    @endif
    
  </div>
  <div class="form-row">
    <div class="form-group col-md-4">
        <label for="consecutivo_inicio">Cons. Facturas</label>
    
        <input type="number" class="form-control {{ $errors->has('consecutivo_inicio') ? ' is-invalid' : '' }}" id="consecutivo_inicio" name="consecutivo_inicio" placeholder="506" value="{{ isset($configFactura) ? $configFactura->consecutivo_inicio : old('consecutivo_inicio','1') }}" required min="1">
        
        
        @if ($errors->has('consecutivo_inicio'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('consecutivo_inicio') }}</strong>
            </div>
        @endif
        
    </div>
    <div class="form-group col-md-4">
        <label for="consecutivo_inicio_ND">Cons. Nota Débito</label>
    
        <input type="number" class="form-control {{ $errors->has('consecutivo_inicio_ND') ? ' is-invalid' : '' }}" id="consecutivo_inicio_ND" name="consecutivo_inicio_ND" placeholder="" value="{{ isset($configFactura) ? $configFactura->consecutivo_inicio_ND : old('consecutivo_inicio_ND','1') }}" required min="1">
        
        
        @if ($errors->has('consecutivo_inicio_ND'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('consecutivo_inicio_ND') }}</strong>
            </div>
        @endif
        
    </div>
    <div class="form-group col-md-4">
        <label for="consecutivo_inicio_NC">Cons. Nota Crédito</label>
    
        <input type="number" class="form-control {{ $errors->has('consecutivo_inicio_NC') ? ' is-invalid' : '' }}" id="consecutivo_inicio_NC" name="consecutivo_inicio_NC" placeholder="" value="{{ isset($configFactura) ? $configFactura->consecutivo_inicio_NC : old('consecutivo_inicio_NC','1') }}" required min="1">
        
        
        @if ($errors->has('consecutivo_inicio_NC'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('consecutivo_inicio_NC') }}</strong>
            </div>
        @endif
        
    </div>
 </div>
 <div class="form-row">
    <!-- <div class="form-group col-md-4">
        <label for="consecutivo_inicio_EI">Cons. Fac. Electrónica</label>
    
        <input type="number" class="form-control {{ $errors->has('consecutivo_inicio_EI') ? ' is-invalid' : '' }}" id="consecutivo_inicio_EI" name="consecutivo_inicio_EI" placeholder="506" value="{{ isset($configFactura) ? $configFactura->consecutivo_inicio_EI : old('consecutivo_inicio_EI','1') }}" required min="1">
        
        
        @if ($errors->has('consecutivo_inicio_EI'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('consecutivo_inicio_EI') }}</strong>
            </div>
        @endif
        
    </div> -->
    <div class="form-group col-md-4">
        <label for="consecutivo_inicio_tiquete">Cons. Tiquetes</label>
    
        <input type="number" class="form-control {{ $errors->has('consecutivo_inicio_tiquete') ? ' is-invalid' : '' }}" id="consecutivo_inicio_tiquete" name="consecutivo_inicio_tiquete" placeholder="506" value="{{ isset($configFactura) ? $configFactura->consecutivo_inicio_tiquete : old('consecutivo_inicio_tiquete','1') }}" required min="1">
        
        
        @if ($errors->has('consecutivo_inicio_tiquete'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('consecutivo_inicio_tiquete') }}</strong>
            </div>
        @endif
        
    </div>
    <div class="form-group col-md-4">
        <label for="consecutivo_inicio_receptor">Cons. Mensaje R.</label>
    
        <input type="number" class="form-control {{ $errors->has('consecutivo_inicio_receptor') ? ' is-invalid' : '' }}" id="consecutivo_inicio_receptor" name="consecutivo_inicio_receptor" placeholder="" value="{{ isset($configFactura) ? $configFactura->consecutivo_inicio_receptor : old('consecutivo_inicio_receptor','1') }}" required min="1">
        
        
        @if ($errors->has('consecutivo_inicio_receptor'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('consecutivo_inicio_receptor') }}</strong>
            </div>
        @endif
        
    </div>
 </div>
  <div class="form-row">
    <div class="form-group col-md-6">
        <label for="atv_user">Usuario Api ATV</label>
    
        <input type="text" class="form-control {{ $errors->has('atv_user') ? ' is-invalid' : '' }}" id="atv_user" name="atv_user" placeholder="" value="{{ isset($configFactura) ? $configFactura->atv_user : old('atv_user') }}">
        
        
        @if ($errors->has('atv_user'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('atv_user') }}</strong>
            </div>
        @endif
        
    </div>
    <div class="form-group col-md-6">
        <label for="atv_password">Contraseña Api ATV</label>
    
        <input type="password" class="form-control {{ $errors->has('atv_password') ? ' is-invalid' : '' }}" id="atv_password" name="atv_password" placeholder="" value="{{ isset($configFactura) ? $configFactura->atv_password : old('atv_password') }}">
        
        
        @if ($errors->has('atv_password'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('atv_password') }}</strong>
            </div>
        @endif
        
    </div>
 </div>
  
  <div class="form-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input {{ $errors->has('certificado') ? ' is-invalid' : '' }}" id="certificado" name="certificado">
            <label class="custom-file-label {{ $errors->has('certificado') ? ' is-invalid' : '' }}" for="certificado">Certificado .p12</label>
            @if ($errors->has('certificado'))
                <div class="error invalid-feedback">
                    <strong>{{ $errors->first('certificado') }}</strong>
                </div>
            @endif
        </div>
         @if(isset($configFactura) && existsCertFile($configFactura))
            <h4 class="label label-success">Certificado Instalado</h4>
        @else 
            <h4 class="label label-danger">Certificado No Instalado</h4>
        @endif
    </div>
<div class="form-group">
    <label for="pin_certificado">PIN certificado</label>
   
       <input type="password" class="form-control {{ $errors->has('pin_certificado') ? ' is-invalid' : '' }}" id="pin_certificado" name="pin_certificado" placeholder="" value="{{ isset($configFactura) ? $configFactura->pin_certificado : old('pin_certificado') }}">
      
    
    @if ($errors->has('pin_certificado'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('pin_certificado') }}</strong>
        </div>
    @endif
    
  </div>

  
   @if(isset($configFactura))
        @can('update', $configFactura)
            <button type="submit" class="btn btn-primary">Guardar</button>
        @endcan
    @else 
        <button type="submit" class="btn btn-primary">Guardar</button>
    @endif
    <a href="/" class="btn btn-default"> Regresar</a>
