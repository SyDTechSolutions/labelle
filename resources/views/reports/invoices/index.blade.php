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
                        <span class="flex">Reporte Facturas</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/reports/invoices" method="GET">
                                <div class="row">
                                  
                                    <div class="col-sm-3">
                                        <select class="form-control custom-select" name="type" id="type">
                                        <option value=""></option>
                                        @foreach($tipoDocumentos as $index => $tipo)
                                            <option value="{{ $index }}" {{ isset($search['type']) && $search['type'] == $index ? 'selected' : ''}}>
                                                {{ $tipo }}
                                            </option>
                                        @endforeach
                                        
                                        </select>
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
                                          <button type="button" class="btn btn-secondary btn-export">Exportar</button>
                                          <input type="hidden" name="print" value="0">  
                                          <input type="hidden" name="export" value="0">  
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
                                    <th scope="col">Tipo</th>
                                    <th scope="col" title="Tiene Nota de Crédito o Débito">NC / ND</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Metodo de Pago</th>
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

                            @foreach($invoices as $invoice)

                                <tr>

                                    <th scope="row">
                                        <div style="display:flex; flex-direction:column; gap:12px;">
                                            <span>

                                                {{ $invoice['consecutivo']}}
                                            </span>
                                            <span>
                                                {{ $invoice['created_at']}}
                                            </span>
                                        </div>
                                    </th>

                                    <td>{{ $invoice['TipoDocumentoName'] }}</td>

                                    <td>{{ $invoice['TipoDocumento'] == '02' || $invoice['TipoDocumento'] == '03' ? 'Sí' : 'No' }}</td>

                                    <!-- <td>{{ $invoice['CondicionVenta'] == '02' ? 'Sí' : 'No' }}</td> -->

                                    <td>{{ $invoice['cliente'] }}</td>

                                    <td>{{ $invoice['MedioPagoName'] }}</td>

                                    <td>{{ money($invoice['uno']) }}</td>

                                    <td>{{ money($invoice['dos']) }}</td>

                                    <td>{{ money($invoice['cuatro']) }}</td>

                                    <td>{{ money($invoice['trece']) }}</td>

                                    <td>

                                        {{ money($invoice['TotalImpuesto'])}}

                                    </td>

                                    <td>{{ money(round($invoice['TotalVentaNeta'])) }}</td>

                                    <td>

                                        @if($invoice['canceled'])

                                            {{ money(round($invoice['TotalComprobante'])) }}

                                        @else

                                            {{ money(round($invoice['TotalWithNota'])) }}

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                                <tr>

                                    

                                    <td colspan="10" class="text-right">

                                       <b>Efectivo:</b> {{  money(round($TotalEfectivo)) }}

                                    </td>

                                    <td class="text-right">

                                        <b>Caja Inicial:</b>

                                    </td>

                                    <td>

                                        {{  money($amountCaja) }}

                                    </td>

                                </tr>

                                <tr>

                                   

                                    <td colspan="10" class="text-right">

                                        <b> Tarjeta:</b> {{  money(round($TotalTarjeta)) }}

                                    </td>

                                    <td class="text-right">

                                       <b> Subtotal:</b>

                                    </td>

                                    <td>

                                        {{  money(round($totalVentas)) }}

                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="10" class="text-right">

                                       <b> Transferencia:</b> {{  money(round($TotalDeposito)) }}

                                    </td>

                                    <td class="text-right">

                                       <b> Impuestos:</b>

                                    </td>

                                    <td>

                                        {{  money(round($totalTaxes)) }}

                                    </td>

                                </tr>

                                <tr>

                                     <td colspan="12" class="text-right">

                                       <b> Total:</b> {{  money(round($totalReporte)) }}

                                    </td>

                                </tr>
                                <tr>

                                    <td colspan="12" class="text-right">

                                        <b> Pendiente:</b> {{  money(round($totalPending)) }}

                                    </td>

                                </tr>

                            

                            </tbody>
                        </table>      

                   </div>
                   <div class="row">
                    <div class="col-md-9">
                    </div>
                    <div class="col-md-3 text-right">
                     <expense-cierre :total-cierre="{{ $totalReporte }}" current-date="{{ $search['end'] }}"></expense-cierre>

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
         $('.btn-export').on('click', function (e) {
             
             $('input[name="export"]').val(1);

             $(this).parents('form').submit();

             $('input[name="export"]').val(0);
         })
       

    </script>
@endsection