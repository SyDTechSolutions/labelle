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
                        <span class="flex">Facturas</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/invoices" method="GET">
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
                                        <select class="form-control custom-select" name="created_by" id="created_by">
                                            <option value="">-Vendedor-</option>
                                            @foreach($sellers as $seller)
                                            <option value="{{ $seller->id }}" {{ isset($search['created_by']) && $search['created_by'] == $seller->id ? 'selected' : ''}}>{{ $seller->name }}</option>
                                            @endforeach
                                           
                                            
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
                    <a href="/invoices/create" class="btn btn-success btn-sm">Crear Factura</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Consecutivo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Tipo Documento</th>
                                    <th scope="col">Condicion Venta</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Estado Hacienda</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                            
                                <tr class="{{ ($invoice->TotalWithNota != $invoice->TotalComprobante) ? 'table-danger': '' }}">
                                    <th scope="row"><a href="/invoices/{{ $invoice->id }}">{{ $invoice->consecutivo }}</a>
                                    <br>
                                    @if($invoice->TipoDocumento == '01' || $invoice->TipoDocumento == '04')
                                        @foreach($invoice->notascreditodebito as $nota)
                                        <small>Nota: {{ $nota->invoice->consecutivo }}</small>
                                        @endforeach
                                    @else
                                        @foreach($invoice->referencias as $nota)
                                        <small>Doc: {{ $nota->NumeroDocumento }}</small>
                                        @endforeach
                                    @endif
                                    </th>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td><a href="/invoices/{{ $invoice->id }}">{{ $invoice->cliente }}</a></td>
                                    <td>{{ $invoice->TipoDocumentoName }}</td>
                                    <td>{{ $invoice->CondicionVentaName }}</td>
                        
                                    <td>{{ money($invoice->TotalComprobante,$invoice->CodigoMoneda) }}</td>
                                    <td>
                                        @if($invoice->fe)
                                            @if(!$invoice->sent_to_hacienda && now()->diffInMinutes($invoice->created_at) < 1)
                                                <span class="label label-warning">Enviando...</span>
                                            @else
                                                @if($invoice->sent_to_hacienda)
                                                    @if($invoice->status_fe)
                                                    <a href="#" data-toggle="modal" data-target="#modalRespHacienda" title="Click para comprobar estado de factura" data-invoice="{{ $invoice->id }}" data-factura="facturaElectronica"><span class="label label-{{ trans('utils.status_hacienda_color.'.$invoice->status_fe) }}">{{ Illuminate\Support\Str::title($invoice->status_fe) }}</span>   </a>
                                                    @else
                                                    <a href="#" data-toggle="modal" data-target="#modalRespHacienda" title="Click para comprobar estado de factura" data-invoice="{{ $invoice->id }}" data-factura="facturaElectronica"><span class="label label-warning">Comprobar</span>   </a>
                                                    @endif
                                                @else
                                                    @if($invoice->status)
                                                    <send-to-hacienda :invoice-id="{{ $invoice->id }}"></send-to-hacienda>
                                                    @else
                                                    <span class="label label-warning">Pendiente</span>
                                                    @endif
                                                
                                                @endif
                                            @endif
                                        @else 
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="oi oi-ellipses"></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="/invoices/{{ $invoice->id }}/notacredito">Generar Nota Crédito</a>
                                                <a class="dropdown-item" href="/invoices/{{ $invoice->id }}/notadebito">Generar Nota Débito</a>
                                                @if($invoice->CondicionVenta == '02') 
                                                    <a class="dropdown-item" href="/invoices/{{ $invoice->id }}/recibopago">Generar Recibo de Pago</a>
                                                @endif
                                                @if($invoice->status && $invoice->fe)
                                    
                                                <a class="dropdown-item" href="/invoices/{{ $invoice->id }}/download/xml">XML</a></li>
                                                
                                                @endif
                                                <!-- <form method="POST" action="{{ url('invoices/'. $invoice->id) }}/cancel" data-confirm="Estas Seguro?">
                                                    @csrf
                                                    {{ method_field('PUT')}}
                                                    <button type="submit" class="dropdown-item">
                                                        Anular Factura
                                                    </button>
                                                </form> -->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                                   @if ($invoices)
                                    <td  colspan="7" class="pagination-container">{!!$invoices->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end'], 'sent_to_hacienda' => $search['sent_to_hacienda'], 'status_fe' => $search['status_fe'], 'created_by' => $search['created_by']])->render()!!}</td>
                                @endif
                            
                            </tbody>
                        </table>

                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<modal-status-hacienda></modal-status-hacienda>
@endsection
@section('scripts')
<script>

  $('#modalRespHacienda').on('show.bs.modal', function (e) {

        var button = $(e.relatedTarget)
        var invoiceId = button.attr('data-invoice');
        var facturaElectronica = button.attr('data-factura')

        window.events.$emit('showStatusHaciendaModal', invoiceId,facturaElectronica);
    })
 
  
</script>
@endsection