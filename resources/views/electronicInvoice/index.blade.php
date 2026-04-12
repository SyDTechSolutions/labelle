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
                        <span class="flex">Facturas Electrónicas</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/electronicinvoice" method="GET">
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
                    <a href="/electronicinvoice/create" class="btn btn-success btn-sm">Crear Factura de Compra</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Consecutivo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Tipo Documento</th>
                                    <th scope="col">Condicion Venta</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Estado Hacienda</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($electronicInvoices as $invoice)
                            
                                <tr class="{{ ($invoice->TotalWithNota != $invoice->TotalComprobante) ? 'table-danger': '' }}">
                                    <th scope="row"><a href="/electronicinvoice/{{ $invoice->id }}">{{ $invoice->consecutivo }}</a>
                                    </th>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td><a href="/electronicinvoice/{{ $invoice->id }}">{{ $invoice->emisor }}</a></td>
                                    <td>Factura Electrónica</td>
                                    <td>{{ $invoice->CondicionVentaName }}</td>
                        
                                    <td>{{ money($invoice->TotalComprobante) }}</td>
                                    <td>
                                        @if($invoice->fe)
                                            @if(!$invoice->sent_to_hacienda && now()->diffInMinutes($invoice->created_at) < 1)
                                                <span class="label label-warning">Enviando...</span>
                                            @else
                                                @if($invoice->sent_to_hacienda)
                                                    @if($invoice->status_fe)
                                                    <a href="#" data-toggle="modal" data-target="#modalRespHacienda" title="Click para comprobar estado de factura" data-invoice="{{ $invoice->id }}" data-factura="facturaCompra"><span class="label label-{{ trans('utils.status_hacienda_color.'.$invoice->status_fe) }}">{{ Illuminate\Support\Str::title($invoice->status_fe) }}</span>   </a>
                                                    @else
                                                    <a href="#" data-toggle="modal" data-target="#modalRespHacienda" title="Click para comprobar estado de factura" data-invoice="{{ $invoice->id }}" data-factura="facturaCompra"><span class="label label-warning">Comprobar</span>   </a>
                                                    @endif
                                                @else
                                                    @if($invoice->status)
                                                    <send-to-hacienda-compra :invoice-id="{{ $invoice->id }}"></send-to-hacienda-compra>
                                                    @else
                                                    <span class="label label-warning">Pendiente</span>
                                                    @endif
                                                
                                                @endif
                                            @endif
                                        @else 
                                        --
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                                   @if ($electronicInvoices)
                                    <td  colspan="7" class="pagination-container">{!!$electronicInvoices->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end'], 'sent_to_hacienda' => $search['sent_to_hacienda'], 'status_fe' => $search['status_fe'], 'created_by' => $search['created_by']])->render()!!}</td>
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
        var facturaCompra = button.attr('data-factura')

        window.events.$emit('showStatusHaciendaModal', invoiceId,facturaCompra);
    })
 
  
</script>
@endsection