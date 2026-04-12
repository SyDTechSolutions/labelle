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
            <h2>{{ $purchase->TipoDocumentoName }}</h2>
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
                @if($purchase->customer)
                <li>{{ $purchase->customer->address }}</li>
                <li>{{ $purchase->customer->phone }}</li>
                @endif
            </ul>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
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
            <h3>Abonos a la cuenta</h3>
            <div class="table-responsive col-sm-12">
                <table class="table">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th class="text-right">Monto</th>
                    <th class="text-right">Modo Pago</th>
                    <th class="text-right">Comprobante</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchase->payments as $index => $payment)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>
                            <p>{{ $payment->created_at }}</p>
                            
                        </td>
                        <td class="text-right">{{ money($payment->amount) }}</td>
                        <td class="text-right">{{ $payment->modoPago }}</td>
                        <td class="text-right">{{ $payment->comprobante }}</td>
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
                        <td>Monto Cuenta</td>
                        <td class="text-right">{{ money($purchase->TotalComprobante) }}</td>
                    </tr>
                    <tr>
                        <td>Total Abonos</td>
                        <td class="pink text-right text-success">{{ money($totalAbonos) }}</td>
                    </tr>
                    <tr>
                        <td>Pendiente</td>
                        <td class="text-right text-danger">{{ money($pendiente) }}</td>
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
            
            <div class="col-md-5 col-sm-12 text-center">
                <button type="button" class="btn btn-light my-1" onclick="printSummary();"><i class="fa fa-paper-plane-o" ></i> Imprimir</button>
                <a href="/cxp" class="btn btn-primary" role="button">Regresar a Cuentas por pagar</a>
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
