
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
                <h2>Reporte de Cxc Vencidas</h2>
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
                        <th scope="col">Fecha</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Factura Proveedor</th>
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
                            <td><span class="text-danger">{{ money($invoice->Pending) }}</span></td>
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
    
                </tbody>
                </table>
            </div>
            </div>
            <div class="row">
            <div class="col-md-7 col-sm-12 text-center text-md-left">
                
            </div>
            <div class="col-md-5 col-sm-12">
             
                
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
                <a href="/reports/cxcs/expired" class="btn btn-primary" role="button">Regresar a Reportes</a>
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
