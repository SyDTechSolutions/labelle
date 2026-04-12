@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/css/flatpickr.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                  <div class="level">
                        <span class="flex">Confirmar Documento</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="row">
                        <div class="col-md-6">
                            <mensaje-receptor :mensajes-receptor="{{ json_encode($MensajesReceptor)}}" :condicion-impuesto="{{ json_encode($CondicionImpuesto)}}" :setting="{{ $setting }}">
                            </mensaje-receptor>
                        </div>
                        <div class="col-md-6">
                            <mensaje-receptor-lote :mensajes-receptor="{{ json_encode($MensajesReceptor)}}" :condicion-impuesto="{{ json_encode($CondicionImpuesto)}}" :setting="{{ $setting }}">
                            </mensaje-receptor-lote>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>

  
</script>
@endsection
