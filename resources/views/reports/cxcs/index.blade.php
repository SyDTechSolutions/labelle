@extends('layouts.app')
@section('header')
<link rel="stylesheet" href="/css/flatpickr.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Cuentas por Cobrar Vencidas</div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/reports/cxcs/expired" method="GET">
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
                                        <button type="submit" class="btn btn-info">Generar</button>
                                        <button type="button" class="btn btn-secondary btn-print">Imprimir</button>
                                          <input type="hidden" name="print" value="0">  
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
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)

                               
                                <tr>    
                                
                                    <th scope="row">{{ $invoice->consecutivo }}</th>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->cliente }}</td>
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
                                   
                                </tr>

                                @endforeach
                                <tr>
                                    <td colspan="5"></td>
                                    <td>
                                        <b>Total: {{ money($total) }}</b> <br>
                                       
                                    </td>
                                    <td>
                                     
                                        <b>Pendiente: {{ money($totalPending) }}</b> <br>
                                    </td>
                                    <td></td>
                                </tr>
                                @if ($invoices)
                                <td colspan="8" class="pagination-container">{!!$invoices->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end']])->render()!!}</td>
                                @endif

                            </tbody>
                        </table>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>

         $('.btn-print').on('click', function (e) {
             
             $('input[name="print"]').val(1);

             $(this).parents('form').submit();
         })
       

    </script>
@endsection 