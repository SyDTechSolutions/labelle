@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Configuracion General</div>

                <div class="card-body">
                    <form action="{{ url('/settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="PATCH">
                        @include('settings.partials.form')
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">Configuracion Factura Electronica</div>

                <div class="card-body">
                    @if($configFactura)
                        <form method="POST" action="{{ url('/configfactura/'. $configFactura->id) }}" class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}<input name="_method" type="hidden" value="PUT">
                                @include('settings.partials.configfactura')
                        </form>
                    @else 
                        <form method="POST" action="{{ url('/settings/'.$setting->id.'/configfactura') }}" class="form-horizontal" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @include('settings.partials.configfactura')
                        </form>
                    @endif
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
 $(function () {
	
       var provincias = $('#provincia'),
        cantones = $('#canton'),
        distritos =  $('#distrito'),
        barrios =  $('#barrio')
		

    cantones.empty();
    distritos.empty();
    barrios.empty();
    
	

    provincias.change(function() {
        var $this =  $(this);
        cantones.empty();
        distritos.empty();
        cantones.append('<option value="">-- Canton --</option>');
        $.each(window.provincias, function(index,provincia) {

            if(provincia.id == $this.val()){
                $.each(provincia.cantones, function(index,canton) {

                    cantones.append('<option value="' + canton.id + '">' + canton.title + '</option>');
                });
              }
        });

    });
     cantones.change(function() {
        var $this =  $(this);
        distritos.empty();
        distritos.append('<option value=""> -- Distrito --</option>');
        $.each(window.provincias, function(index,provincia) {
           
            if(provincia.id == provincias.val())
                $.each(provincia.cantones, function(index,canton) {
                  
                     if(canton.id == $this.val())
                     {
                      $.each(canton.distritos, function(index,distrito) {

                          distritos.append('<option value="' + distrito.id + '">' + distrito.title + '</option>');
                      });
                      
                     }
                });
        });

    });
    
    distritos.change(function() {
        var $this =  $(this);
        barrios.empty();
        barrios.append('<option value=""> -- Barrio --</option>');
        $.each(window.provincias, function(index,provincia) {
           
            if(provincia.id == provincias.val())
                $.each(provincia.cantones, function(index,canton) {
                  
                     if(canton.id == cantones.val())
                     {
                      $.each(canton.distritos, function(index,distrito) {

                          if(distrito.id == $this.val())
                            {
                                $.each(distrito.barrios, function(index,barrio) {

                                    barrios.append('<option value="' + barrio.id + '">' + barrio.title + '</option>');
                                });
                            }
                      });
                      
                     }
                });
        });

	});

	@if($configFactura)
	  	setTimeout(function(){

                $('#provincia option[value="{{ $configFactura->provincia }}"]').attr("selected", true);
                $('#provincia').change();
                $('#canton option[value="{{ $configFactura->canton }}"]').attr("selected", true);
			    $('#canton').change();
                $('#distrito option[value="{{ $configFactura->distrito }}"]').attr("selected", true);
                $('#distrito').change();
                $('#barrio option[value="{{ $configFactura->barrio }}"]').attr("selected", true);
            }, 100);
	@endif

});
</script>
@endsection