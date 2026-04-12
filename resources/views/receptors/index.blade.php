@extends('layouts.app')
@section('header')
<link rel="stylesheet" href="/css/flatpickr.min.css">
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="level">
                        <span class="flex">Mensajes de confirmación</span>
                        <div class="actions">

                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/receptor/mensajes" method="GET">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="search" class="form-control input-sm" placeholder="Buscar..." name="q" value="{{ $search['q'] }}">
                                </div>
                                <div class="col-sm-3">

                                    <div class="input-group mb-3 flatpickr">
                                        <input data-input type="text" name="start" class="form-control" placeholder="Fecha" value="{{ $search['start'] }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-clear><i class="oi oi-circle-x"></i></span>
                                        </div>
                                    </div>




                                </div>
                                <div class="col-sm-3">

                                    <div class="input-group mb-3 flatpickr">
                                        <input data-input type="text" class="form-control" placeholder="Fecha" name="end" value="{{ $search['end'] }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-clear><i class="oi oi-circle-x"></i></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-3">
                                        <select class="form-control custom-select" name="status_fe" id="status_fe">
                                            <option value="">-Estado Hacienda-</option>
                                            <option value="aceptado" {{ isset($search['status_fe']) && $search['status_fe'] == 'aceptado' ? 'selected' : ''}}>Aceptado</option>
                                            <option value="procesando" {{ isset($search['status_fe']) && $search['status_fe'] == 'procesando' ? 'selected' : ''}}>Procesando</option>
                                            <option value="rechazado" {{ isset($search['status_fe']) && $search['status_fe'] == 'rechazado' ? 'selected' : ''}}>Rechazado</option>
                                           
                                            
                                        </select>
                                    
                                        
                                    </div>
                                    <div class="col-sm-3">
                                        <select class="form-control custom-select" name="sent_to_hacienda" id="sent_to_hacienda">
                                            <option value="">-Envio Hacienda-</option>
                                            <option value="0" {{ isset($search['sent_to_hacienda']) && $search['sent_to_hacienda'] == 0 ? 'selected' : ''}}>No enviado hacienda</option>
                                            <option value="1" {{ isset($search['sent_to_hacienda']) && $search['sent_to_hacienda'] == 1 ? 'selected' : ''}}>Enviado hacienda</option>
                                           
                                            
                                        </select>
                                    
                                        
                                    </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <a href="/receptor/mensajes/create" class="btn btn-success btn-sm">Confirmar Comprobante</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Conse Receptor.</th>
                                    <th scope="col">Clave Emisor</th>
                                    <th scope="col">Emisor</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Mensaje</th>
                                    <th>Estado Hacienda</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($receptors as $receptor)

                                <tr>
                                    <td>{{ $receptor->created_at }}</td>
                                    <th scope="row">{{ $receptor->NumeroConsecutivoReceptor }}</th>

                                    <td>{{ $receptor->Clave }}</td>

                                    <td class="py-2 px-2">{{ $receptor->NumeroCedulaEmisor }} - {{ $receptor->nombre_emisor }}</td>

                                    <td>{{ money($receptor->TotalFactura) }}</td>
                                    <td>{{ $receptor->MensajeName }}</td>

                                    <td>
                                       
                                        @if(!$receptor->sent_to_hacienda && now()->diffInMinutes($receptor->created_at) < 1)
                                            <span class="label label-warning">Enviando...</span>
                                        @else
                                            @if($receptor->sent_to_hacienda)
                                                @if($receptor->status_fe)
                                                <a href="#" data-toggle="modal" data-target="#modalRespHacienda" title="Click para comprobar estado de factura" data-invoice="{{ $receptor->id }}"><span class="label label-{{ trans('utils.status_hacienda_color.'.$receptor->status_fe) }}">{{ Illuminate\Support\Str::title($receptor->status_fe) }}</span> </a>
                                                @else
                                                <a href="#" data-toggle="modal" data-target="#modalRespHacienda" title="Click para comprobar estado de factura" data-invoice="{{ $receptor->id }}"><span class="label label-warning">Comprobar</span> </a>
                                                @endif
                                            @else
                                                @if($receptor->status)
                                                <send-mensaje-to-hacienda :receptor-id="{{ $receptor->id }}"></send-mensaje-to-hacienda>
                                                @else
                                                <span class="label label-warning">Pendiente</span>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if ($receptors)
                                <td colspan="7" class="pagination-container">{!!$receptors->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end'], 'sent_to_hacienda' => $search['sent_to_hacienda'], 'status_fe' => $search['status_fe']])->render()!!}</td>
                                @endif

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<modal-status-mensaje-hacienda></modal-status-mensaje-hacienda>
@endsection
@section('scripts')
<script>
    $('#modalRespHacienda').on('show.bs.modal', function(e) {

        var button = $(e.relatedTarget)
        var invoiceId = button.attr('data-invoice');

        window.events.$emit('showStatusHaciendaModal', invoiceId);
    })
</script>
@endsection