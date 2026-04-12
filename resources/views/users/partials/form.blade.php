<div class="form-group">
    <label for="dni">Identificación</label>
    <input type="text" class="form-control {{ $errors->has('dni') ? ' is-invalid' : '' }}" id="dni" name="dni" placeholder="" value="{{ isset($user) ? $user->dni : old('dni') }}">
    @if ($errors->has('dni'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('dni') }}</strong>
        </div>
    @endif
  </div>

<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="" value="{{ isset($user) ? $user->name : old('name') }}">
    @if ($errors->has('name'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
    @endif
  </div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="" value="{{ isset($user) ? $user->email : old('email') }}">
    @if ($errors->has('email'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </div>
    @endif
  </div>
  <div class="form-group">
  
        <label for="role">Rol</label>
        <select class="form-control custom-select {{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" id="role" >
                <option value="">-- Selecciona un rol --</option>
            @foreach($roles as $role)    
                <option value="{{ $role->id }}" {{ isset($user) && $user->hasRole($role->name) ? 'selected' : (old('role') == $role->id ? 'selected' : '')  }}>{{ $role->name }}</option>
            @endforeach
        </select>
               
        @if ($errors->has('role'))
            <div class="error invalid-feedback">
                <strong>{{ $errors->first('role') }}</strong>
            </div>
        @endif
            
 </div>
  <div class="form-group">
    <label for="password">Contraseña</label>
    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password"  placeholder="">
    @if ($errors->has('password'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </div>
    @endif
  </div>
  <div class="form-group">
      <label for="password_confirmation">Confirmación de Contraseña</label>
      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('password_confirmation') }}">
            
       
 </div>
 <div class="form-group">
    <label for="name">Porcentaje de Comisión</label>
    <input type="text" class="form-control {{ $errors->has('commission') ? ' is-invalid' : '' }}" id="commission" name="commission" placeholder="" value="{{ isset($user) ? $user->commission : old('commission') }}">
    @if ($errors->has('commission'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('commission') }}</strong>
        </div>
    @endif
  </div>
   @if(isset($user))
        @can('update', $user)
            <button type="submit" class="btn btn-primary">Guardar</button>
        @endcan
    @else 
        <button type="submit" class="btn btn-primary">Guardar</button>
    @endif
    <a href="/users" class="btn btn-default"> Regresar</a>
