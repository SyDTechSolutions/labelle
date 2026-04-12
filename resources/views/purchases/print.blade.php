
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
            <h2>Factura</h2>
            <p class="pb-3"># {{ $purchase->consecutivo}}</p>
            <ul class="px-0 list-unstyled">
                <li>Total</li>
                <li class="lead text-bold-800">{{ money($purchase->TotalComprobante) }}</li>
            </ul>
            </div>
        </div>
        <!--/ Invoice Company Details -->
        <!-- Invoice Customer Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-sm-12 text-center text-md-left">
            <p class="text-muted">Facturado A:</p>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-left">
            <ul class="px-0 list-unstyled">
                <li class="text-bold-800">{{ $purchase->cliente }}</li>
                <li>{{ $purchase->email }}</li>
                @if($purchase->provider)
                <li>{{ $purchase->provider->address }}</li>
                <li>{{ $purchase->provider->phone }}</li>
                @endif
            </ul>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
            <p>
                <span class="text-muted">Creador:</span> {{ Optional($purchase->creator)->name }}</p>
            <p>
            <p>
                <span class="text-muted">Fecha Factura:</span> {{ $purchase->created_at }}</p>
            <p>
                <span class="text-muted">Condición Venta :</span> {{ $purchase->CondicionVentaName }}</p>
            <p>
                <span class="text-muted">Medio Pago :</span> {{ $purchase->MedioPagoName }}</p>
            </div>
        </div>
        <!--/ Invoice Customer Details -->
        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-2">
            <div class="row">
            <div class="table-responsive col-sm-12">
                <table class="table">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Item &amp; Descripción</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">% Descuento</th>
                    <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->lines as $index => $line)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>
                            <p>{{ $line->Detalle }}</p>
                            
                        </td>
                        <td class="text-right">{{ money($line->PrecioUnitario) }}</td>
                        <td class="text-right">{{ $line->Cantidad }}</td>
                        <td class="text-right">{{ $line->PorcentajeDescuento }}</td>
                        <td class="text-right">{{ money($line->SubTotal) }}</td>
                    </tr>
                    @endforeach
                
                </tbody>
                </table>
            </div>
            </div>
            <div class="row">
            <div class="col-md-7 col-sm-12 text-center text-md-left">
                
            </div>
            <div class="col-md-5 col-sm-12">
                <p class="lead">Totales</p>
                <div class="table-responsive">
                <table class="table" style="font-size:12px;">
                    <tbody>
                    <tr>
                        <td>Sub Total</td>
                        <td class="text-right">{{ money($purchase->TotalVenta) }}</td>
                    </tr>
                    <tr>
                        <td>Descuentos</td>
                        <td class="pink text-right text-danger">(-) {{ money($purchase->TotalDescuentos) }}</td>
                    </tr>
                    <tr>
                        <td>Impuestos (13%)</td>
                        <td class="text-right">{{ money($purchase->TotalImpuesto) }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold-800">Total</td>
                        <td class="text-bold-800 text-right"> {{ money($purchase->TotalComprobante + $purchase->ajuste) }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold-800">Ajuste</td>
                        <td class="text-bold-800 text-right"> {{ money($purchase->ajuste) }}</td>
                    </tr>
                    <tr>
                        <td class="text-bold-800">Total con Ajuste</td>
                        <td class="text-bold-800 text-right"> {{ money($purchase->TotalComprobante) }}</td>
                    </tr>
                    <tr>
                        <td>Pago con</td>
                        <td class="pink text-right">{{ money($purchase->pay_with) }}</td>
                    </tr>
                    <tr class="bg-grey bg-lighten-4">
                        <td class="text-bold-800">Cambio</td>
                        <td class="text-bold-800 text-right">{{ money($purchase->change) }}</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            
            </div>
            </div>
        </div>
        <!-- Invoice Footer -->
        <div id="invoice-footer">
            <div class="row">
            <div class="col-md-7 col-sm-12">
                <b>Observaciones:</b> {{ $purchase->observations }}
            </div>
            <div class="col-md-5 col-sm-12 text-center">
                <button type="button" class="btn btn-light my-1" onclick="printSummary();"><i class="fa fa-paper-plane-o" ></i> Imprimir</button>
                <a href="/purchases" class="btn btn-primary" role="button">Regresar a Facturas de compra</a>
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
