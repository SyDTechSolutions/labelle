@extends('layouts.app')
@section('header')
    <link rel="stylesheet" href="/css/flatpickr.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Cuentas por Cobrar Pagadas </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/cxc/Pagadas" method="GET">
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
                                        <div class="form-group">
                                          <button type="submit" class="btn btn-info">Buscar</button> 
                                        </div> 
                                    </div>
                                </div>
                            </form>
                    </div>
                   
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
                                    <th scope="col">Pendiente</th>
                                    <th scope="col">Vencimiento</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $invoice)
                                @if($invoice->PlazoCredito && $invoice->PlazoCredito == '30 días')
                                <tr class="{{ ($invoice->created_at->addDays(30)->lessThan( Illuminate\Support\Carbon::now() )) ? 'table-danger': '' }}">
                                @elseif($invoice->PlazoCredito && $invoice->PlazoCredito == '45 días')
                                <tr class="{{ ($invoice->created_at->addDays(45)->lessThan( Illuminate\Support\Carbon::now() )) ? 'table-danger': '' }}">
                                @else
                                <tr class="{{ ($invoice->PlazoCredito && Illuminate\Support\Carbon::parse($invoice->PlazoCredito)->lessThan( Illuminate\Support\Carbon::now() )) ? 'table-danger': '' }}">    
                                @endif
                                    <th scope="row"><a href="/invoices/{{ $invoice->id }}">{{ $invoice->consecutivo }}</a></th>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td><a href="/invoices/{{ $invoice->id }}">{{ $invoice->cliente }}</a></td>
                                    <td>{{ $invoice->TipoDocumentoName }}</td>
                                    <td>{{ $invoice->CondicionVentaName }}</td>
                        
                                    <td>{{ money($invoice->TotalComprobante) }}</td>
                                    <td><span class="text-danger">{{ money($invoice->cxc_pending_amount) }}</span></td>
                                    <td>
                                    @if($invoice->PlazoCredito && $invoice->PlazoCredito == '30 días')
                                       {{ $invoice->created_at->addDays(30)->toDateString() }}
                                    @elseif($invoice->PlazoCredito && $invoice->PlazoCredito == '45 días')
                                        {{ $invoice->created_at->addDays(45)->toDateString() }}
                                    @else
                                        {{ $invoice->PlazoCredito }} 
                                    @endif 
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="oi oi-ellipses"></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="/cxc/{{ $invoice->id }}/payment"  data-toggle="modal"
                                                    data-target="#cxcModal" data-customer="{{ $invoice->customer_id}}">Estado de cuenta</a>
                                               
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                                   @if ($invoices)
                                    <td  colspan="9" class="pagination-container">{!!$invoices->appends(['q' => $search['q']])->render()!!}</td>
                                @endif
                            
                            </tbody>
                        </table>
                        <payments-modal></payments-modal>
                        <cxc-modal></cxc-modal>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('#paymentsModal').on('show.bs.modal', function (e) {

            var button = $(e.relatedTarget)
            var invoice_id = button.attr('data-invoice');
            
            window.events.$emit('showPaymentsModal', invoice_id);
        })

        $('#cxcModal').on('show.bs.modal', function (e) {

        var button = $(e.relatedTarget)
        var customer_id = button.attr('data-customer');
        //manda el tipo cuando es CxcPagadas, toda la página es una copia de index.blade de CxC
        window.events.$emit('showCxcModal', customer_id,'cxcP');
        })
</script>
@endsection