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
                        <span class="flex">Reporte Facturas de Proveedor</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/reports/facturasProveedor" method="GET">
                                <div class="row">
                                  
                                     <div class="col-sm-3">
                                        <input type="search" class="form-control input-sm" placeholder="Buscar..." name="q" value="{{ $search['q'] }}">
                                     </div>
                                     <div class="col-sm-3">
                                        <select class="form-control custom-select" name="condicion" id="condicion">
                                        <option value="">-- Condición Venta --</option>
                                        @foreach($condicionVentas as $index => $condicion)
                                            <option value="{{ $index }}" {{ isset($search['condicion']) && $search['condicion'] == $index ? 'selected' : ''}}>
                                                {{ $condicion }}
                                            </option>
                                        @endforeach
                                        
                                        </select>
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
                                        <select class="form-control custom-select" name="MedioPago" id="MedioPago">
                                        <option value="">-- Medio Pago --</option>
                                        @foreach($medioPagos as $index => $medioPago)
                                            <option value="{{ $index }}" {{ isset($search['MedioPago']) && $search['MedioPago'] == $index ? 'selected' : ''}}>
                                                {{ $medioPago }}
                                            </option>
                                        @endforeach
                                        
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
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
                                    <th scope="col" colspan="2">Factura Proveedor</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Condición Venta</th>
                                    <th scope="col">Medio Pago</th>
                                    <th scope="col">IVA 1%</th>
                                    <th scope="col">IVA 2%</th>
                                    <th scope="col">IVA 4%</th>
                                    <th scope="col">IVA 13%</th>
                                    <th scope="col">Total IVA</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Total</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <th scope="row" colspan="2">{{ $purchase->factura_proveedor }}</th>
                                    <td>{{ $purchase->fecha_factura }}</td>
                                    <td>{{ $purchase->cliente}}</td>
                                    <td>{{ $purchase->CondicionVenta}}</td>
                                    <td>{{ $purchase->MedioPago }}</td>
                                    @foreach($impuestos as $x=>$i)
                                        @if($impuestos[$x]['factura']==$purchase->id)
                                            <td>{{ $impuestos[$x]['Iva1']}}</td>
                                            <td>{{ $impuestos[$x]['Iva2']}}</td>
                                            <td>{{ $impuestos[$x]['Iva4']}}</td>
                                            <td>{{ $impuestos[$x]['Iva13']}}</td>
                                            <td>
                                                {{ $impuestos[$x]['totalIva']}}
                                            </td>
                                        @endif
                                    @endforeach
                                    <td>{{ money($purchase->TotalVentaNeta) }}</td>
                                    <td>
                                        {{ money($purchase->TotalComprobante) }}
                                    </td>
                                </tr>
                            @endforeach
                                <tr>
                                    
                                    <td colspan="11" class="text-right">
                                       <b>Efectivo:</b> {{  money($TotalEfectivo) }}
                                    </td>
                                    <td colspan="11" class="text-right">
                                        <b> Tarjeta:</b> {{  money($TotalTarjeta) }}
                                    </td>
                                </tr>
                                <tr>
                                   
                                    <td colspan="11" class="text-right">
                                       <b> Transferencia:</b> {{  money($TotalDeposito) }}
                                    </td>
                                    <td class="text-right">
                                       <b> Impuestos:</b>
                                    </td>
                                    <td>
                                        {{  money($totalTaxes) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="13" class="text-right">
                                       <b> Total:</b> {{money($totalReporte)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>      

                   </div>
                   <div class="row">
                    <div class="col-md-9">
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