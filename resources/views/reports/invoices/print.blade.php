
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

                                <b>Subtotal:</b>

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
            </div>
        </div>
        <!-- Invoice Footer -->
        <div id="invoice-footer">
            <div class="row">
            <div class="col-md-7 col-sm-12">
                
            </div>
            <div class="col-md-5 col-sm-12 text-center">
                <button type="button" class="btn btn-light my-1" onclick="printSummary();"><i class="fa fa-paper-plane-o" ></i> Imprimir</button>
                <a href="/reports/invoices" class="btn btn-primary" role="button">Regresar a Reportes</a>
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
