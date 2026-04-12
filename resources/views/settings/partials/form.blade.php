<div class="form-group">

    <label for="company">Nombre del Negocio</label>
    <input type="text" class="form-control {{ $errors->has('company') ? ' is-invalid' : '' }}" id="company" name="company" placeholder="" value="{{ isset($setting) ? $setting->company : old('company') }}">
    @if ($errors->has('company'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('company') }}</strong>
    </div>
    @endif

</div>

<div class="form-group">
    <label for="ide">Cedula Jurídica</label>
    <input type="text" class="form-control {{ $errors->has('ide') ? ' is-invalid' : '' }}" id="ide" name="ide" placeholder="" value="{{ isset($setting) ? $setting->ide : old('ide') }}">
    @if ($errors->has('ide'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('ide') }}</strong>
    </div>
    @endif
</div>
<div class="form-group">
    <label for="address">Dirección</label>

    <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" name="address" placeholder="" value="{{ isset($setting) ? $setting->address : old('address') }}">


    @if ($errors->has('address'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('address') }}</strong>
    </div>
    @endif

</div>
<div class="form-group">
    <label for="phone">Teléfono</label>

    <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" placeholder="" value="{{ isset($setting) ? $setting->phone : old('phone') }}">


    @if ($errors->has('phone'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('phone') }}</strong>
    </div>
    @endif

</div>
<div class="form-group">
    <label for="consecutivo">Consecutivo de inicio</label>

    <input type="number" class="form-control {{ $errors->has('consecutivo') ? ' is-invalid' : '' }}" id="consecutivo" name="consecutivo" placeholder="" value="{{ isset($setting) ? $setting->consecutivo : old('consecutivo') }}">


    @if ($errors->has('consecutivo'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('consecutivo') }}</strong>
    </div>
    @endif

</div>
<div class="form-group">

    <label for="provincia">Habilitar Factura Electrónica</label>
    <select class="form-control custom-select {{ $errors->has('fe') ? ' is-invalid' : '' }}" name="fe" id="fe" required>
        <!-- <option value="">-- Selecciona un rol --</option> -->

        <option value="1" {{ isset($setting) ? ($setting->fe == '1' ? 'selected' : '') : '' }}>Si</option>
        <option value="0" {{ isset($setting) ? ($setting->fe == '0' ? 'selected' : '') : '' }}>No</option>

    </select>

    @if ($errors->has('fe'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('fe') }}</strong>
    </div>
    @endif

</div>
<div class="form-group">
    <label for="consecutivo">Impresora Tickets</label>

    <input type="text" class="form-control {{ $errors->has('printer_tickets') ? ' is-invalid' : '' }}" id="printer_tickets" name="printer_tickets" placeholder="" value="{{ isset($setting) ? $setting->printer_tickets : old('printer_tickets') }}">


    @if ($errors->has('printer_tickets'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('printer_tickets') }}</strong>
    </div>
    @endif

</div>
<div class="form-group">
    <label for="notes">Notas</label>
    <textarea name="notes" id="notes" cols="30" rows="10" class="form-control {{ $errors->has('notes') ? ' is-invalid' : '' }}">
    {{ isset($setting) ? $setting->notes : old('notes') }}
    </textarea>



    @if ($errors->has('notes'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('notes') }}</strong>
    </div>
    @endif

</div>
<div class="form-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input {{ $errors->has('logo_path') ? ' is-invalid' : '' }}" id="logo_path" name="logo_path">
        <label class="custom-file-label {{ $errors->has('logo_path') ? ' is-invalid' : '' }}" for="logo_path">Escoge un logo</label>
        @if ($errors->has('logo_path'))
        <div class="error invalid-feedback">
            <strong>{{ $errors->first('logo_path') }}</strong>
        </div>
        @endif
    </div>
</div>
@if(isset($setting) && $setting->logo_path)
<div class="form-group">
    <img src="{{ $setting->logo() }}" alt="{{ $setting->company }}" class="img-thumbnail">
</div>
@endif

<div class="form-group">

    <label for="provincia">Verificar Existencias de inventario</label>
    <select class="form-control custom-select {{ $errors->has('verificar_existencias') ? ' is-invalid' : '' }}" name="verificar_existencias" id="verificar_existencias" required>
        <!-- <option value="">-- Selecciona un rol --</option> -->

        <option value="1" {{ isset($setting) ? ($setting->verificar_existencias == '1' ? 'selected' : '') : '' }}>Si</option>
        <option value="0" {{ isset($setting) ? ($setting->verificar_existencias == '0' ? 'selected' : '') : '' }}>No</option>

    </select>

    @if ($errors->has('verificar_existencias'))
    <div class="error invalid-feedback">
        <strong>{{ $errors->first('verificar_existencias') }}</strong>
    </div>
    @endif

</div>


@if(isset($setting))
@can('update', $setting)
<button type="submit" class="btn btn-primary">Guardar</button>
@endcan
@else
<button type="submit" class="btn btn-primary">Guardar</button>
@endif
<a href="/" class="btn btn-default"> Regresar</a>