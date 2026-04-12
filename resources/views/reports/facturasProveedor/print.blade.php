
@extends('layouts.app')
@section('content')
<div class="container">
    <section class="card">
        <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <div id="invoice-company-details" class="row">
            <div class="col-md-6 col-sm-12 text-center text-md-left">
            <div class="media">
                <img src="{{ $setting->logo() }}" alt="company logo" class="" height="80">
                <div class="media-body">
                <ul class="ml-2 px-0 list-unstyled">
                    <li class="text-bold-800">{{ $setting->company }}</li>
                    <li>{{ $setting->ide }}</li>
                    <li>{{ $setting->address }}</li>
                    <li>{{ $setting->phone }}</li>
                    
                </ul>
                </div>
            </div>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
                <h2>Reporte de Facturas</h2>
                <h3 class="pb-3 text-danger bold"></h3>
                <ul class="px-0 list-unstyled">
                    <li>Fecha generado</li>
                    <li class="lead text-bold-800">{{ Carbon\Carbon::now()->toDateTimeString() }}</li>
                </ul>
            </div>
        </div>
        <!--/ Invoice Company Details -->
    
        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-2">
            <div class="row">
            <div class="table-responsive col-sm-12">
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
            </div>
        </div>
        <!-- Invoice Footer -->
        <div id="invoice-footer">
            <div class="row">
            <div class="col-md-7 col-sm-12">
                
            </div>
            <div class="col-md-5 col-sm-12 text-center">
                <button type="button" class="btn btn-light my-1" onclick="printSummary();"><i class="fa fa-paper-plane-o" ></i> Imprimir</button>
                <a href="/reports/facturasProveedor" class="btn btn-primary" role="button">Regresar a Reportes Proveedor</a>
            </div>
            </div>
        </div>
        <!--/ Invoice Footer -->
    </div>
</section>
</div>
@endsection
@section('scripts')
<script>
    function printSummary() {
            window.print();
        }
        
        window.onload = printSummary;
</script>
@endsection
