@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Crear Cliente</div>

                <div class="card-body">
                    <form action="{{ url('customers') }}" method="POST">
                        @csrf
                        @include('customers.partials.form')
                    </form>
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
        distritos =  $('#distrito');
       // barrios =  $('#barrio')
		

    cantones.empty();
    distritos.empty();
    //barrios.empty();
    
	

    provincias.change(function() {
        var $this =  $(this);
        cantones.empty();
        distritos.empty();
        cantones.append('<option value="">-- Canton --</option>');
        distritos.append('<option value="">-- Distrito --</option>');
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
        //barrios.empty();
        //barrios.append('<option value=""> -- Barrio --</option>');
        $.each(window.provincias, function(index,provincia) {
           
            if(provincia.id == provincias.val())
                $.each(provincia.cantones, function(index,canton) {
                  
                     if(canton.id == cantones.val())
                     {
                      $.each(canton.distritos, function(index,distrito) {

                          if(distrito.id == $this.val())
                            {
                                // $.each(distrito.barrios, function(index,barrio) {

                                //     barrios.append('<option value="' + barrio.id + '">' + barrio.title + '</option>');
                                // });
                            }
                      });
                      
                     }
                });
        });

	});


});
</script>
@endsection