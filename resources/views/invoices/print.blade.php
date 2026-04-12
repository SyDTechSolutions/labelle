
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
                    <li class="text-bold-800 mb-1">{{ $setting->configFactura->nombre }}</li>
                    <li class="text-bold-800 mb-1">{{ $setting->configFactura->nombre_comercial }}</li>
                    <li class="mb-1">{{ $setting->configFactura->identificacion }}</li>
                    <li class="mb-1">{{ Illuminate\Support\Str::title($setting->configFactura->otras_senas) }}</li>
                    <li class="mb-1">{{ $setting->configFactura->telefono }}</li>
                    
                </ul>
                </div>
            </div>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
                <h2>{{ $invoice->TipoDocumentoName }}</h2>
                <!-- <h3 class="pb-3 text-danger bold"># {{ $invoice->consecutivo}}</h3> -->
                <p class="mb-1"><b>Código Actividad:</b> {{ $setting->configFactura->CodigoActividad }}</p>
                <!-- <ul class="px-0 list-unstyled">
                    <li>Total</li>
                    <li class="lead text-bold-800">{{ money($invoice->TotalComprobante) }}</li>
                </ul> -->
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
                <li class="text-bold-800">{{ $invoice->cliente }}</li>
                <li>{{ $invoice->email }}</li>
                @if($invoice->identificacion_cliente)
                <li>Identificación: {{ $invoice->identificacion_cliente }}</li>
                @endif
                @if($invoice->customer)
                <li>{{ $invoice->customer->address }}</li>
                <li>{{ $invoice->customer->phone }}</li>
                @endif
            </ul>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
            <p>
                <span class="text-muted">Vendedor:</span> {{ Optional($invoice->creator)->name }}</p>
            <p>
            <p>
                <span class="text-muted">Fecha Factura:</span> {{ $invoice->created_at }}</p>
            <p>
                <span class="text-muted">Condición Venta :</span> {{ $invoice->CondicionVentaName }}</p>
            <p>
                <span class="text-muted">Medio Pago :</span> {{ $invoice->MedioPagoName }}</p>
            </div>
        </div>
        <!--/ Invoice Customer Details -->
        
        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-2" >

            <div class="row">

            <div class="table-responsive col-sm-12">

                <table class="table">

                <thead>

                    <tr>

                    <th>#</th>

                    <th>Descripción</th>

                    <th class="text-right">Precio Unitario</th>

                    <th class="text-right">Cant.</th>

                    <th class="text-right">Subtotal</th>

                    <th class="text-right">Desc.</th>

                    <th class="text-right">Total</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($invoice->lines as $index => $line)

                    <tr>

                        @if($invoice->CodigoMoneda == "USD")

                            <th scope="row">{{ $index + 1 }}</th>

                            <td>

                            {{ $line['Detalle'] }}

                                

                            </td>

                            <td class="text-right">{{ money($line['PrecioUnitario'],'$') }}</td>

                            <td class="text-right">{{ $line['Cantidad'] }}</td>

                            <td class="text-right">{{ money($line['MontoTotal'],'$') }}</td>

                            <td class="text-right">{{ $line['PorcentajeDescuento'] }}%</td>

                            <td class="text-right">{{ money($line['SubTotal'],'$') }}</td>

                        @else

                            <th scope="row">{{ $index + 1 }}</th>

                            <td>

                            {{ $line['Detalle'] }}

                                

                            </td>

                            <td class="text-right">{{ money($line['PrecioUnitario']) }}</td>

                            <td class="text-right">{{ $line['Cantidad'] }}</td>

                            <td class="text-right">{{ money($line['MontoTotal']) }}</td>

                            <td class="text-right">{{ $line['PorcentajeDescuento'] }}%</td>

                            <td class="text-right">{{ money($line['SubTotal']) }}</td>

                        @endif

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

                    @if($invoice->CodigoMoneda=="USD")

                        <tr>

                            <td>Sub Total</td>

                            <td class="text-right" style="text-align:right;">{{ money($invoice->TotalVenta,"$") }}</td>

                        </tr>

                        <tr>

                            <td>Descuentos</td>

                            <td class="pink text-right text-danger" style="text-align:right;    color: #dc3545 !important;">(-) {{ money($invoice->TotalDescuentos,"$") }}</td>

                        </tr>

                        @foreach($taxes as $tax)
                            <tr>

                                <td>Impuesto ({{ (int)$tax['Tarifa'] }}%) IVA</td>

                                <td class="text-right" style="text-align:right;">{{ money($tax['TotalMontoImpuesto']) }}</td>

                            </tr>
                        @endforeach

                        @if($invoice->MedioPago == '02')

                        <tr>

                            <td>IVA Devuelto:</td>

                            <td class="pink text-right text-danger" style="text-align:right;color: #dc3545 !important;">(-) {{ money($invoice->TotalIVADevuelto,"$") }} </td>

                        </tr>

                        @endif

                        <tr>

                            <td class="text-bold-800">Total</td>

                            <td class="text-bold-800 text-right" style="text-align:right;"> {{ money($invoice->TotalComprobante,"$") }}</td>

                        </tr>

                    @else

                        <tr>

                            <td>Sub Total</td>

                            <td class="text-right" style="text-align:right;">{{ money($invoice->TotalVenta) }}</td>

                        </tr>

                        <tr>

                            <td>Descuentos</td>

                            <td class="pink text-right text-danger" style="text-align:right;    color: #dc3545 !important;">(-) {{ money($invoice->TotalDescuentos) }}</td>

                        </tr>

                        @foreach($taxes as $tax)
                        <tr>

                            <td>Impuesto ({{ $tax['Tarifa'] }}) IVA</td>

                            <td class="text-right" style="text-align:right;">{{ money($tax['TotalMontoImpuesto']) }}</td>

                        </tr>
                        @endforeach

                        @if($invoice->MedioPago == '02')

                        <tr>

                            <td>IVA Devuelto:</td>

                            <td class="pink text-right text-danger" style="text-align:right;color: #dc3545 !important;">(-) {{ money($invoice->TotalIVADevuelto) }} </td>

                        </tr>

                        @endif

                        <tr>

                            <td class="text-bold-800">Total</td>

                            <td class="text-bold-800 text-right" style="text-align:right;"> {{ money($invoice->TotalComprobante) }}</td>

                        </tr>



                    @endif

                    </tbody>

                </table>

                </div>

            

            </div>

            </div>

        </div>

        <!-- Invoice Footer -->
        <div id="invoice-footer" >
            <div class="">
                <b> Valor en letras:</b> <span class="uppercase" style="text-transform:uppercase;">{{ $TotalEnLetras }} {{ $invoice->CodigoMoneda }}</span><br>
                 @if($invoice->NumeroConsecutivo)
                 <b>Conse:</b> {{ $invoice->NumeroConsecutivo }} <br>
                @endif
                @if($invoice->clave_fe)
                <b>Clave:</b> {{ $invoice->clave_fe }} <br>
                @endif
            </div>
            <div class="row">
            <div class="col-md-7 col-sm-12">
            <b>Observaciones:</b> {{ $invoice->observations }}
            </div>
            <div class="row">
            <div class="col-md-7 col-sm-12">
                @include('invoices.partials.notaHacienda')
            </div>
            <div class="col-md-5 col-sm-12 text-center">
                <button type="button" class="btn btn-light my-1" onclick="printSummary();"><i class="fa fa-paper-plane-o" ></i> Imprimir</button>
                <a href="/invoices" class="btn btn-primary" role="button">Regresar a facturación</a>
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