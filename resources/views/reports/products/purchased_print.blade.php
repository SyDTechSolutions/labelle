
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
                <h2>Reporte de Productos Comprados</h2>
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
                        <th scope="col">Fecha</th>
                        <th scope="col">Factura</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Código</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio Compra</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                            
                                <tr>
                                    <th scope="row">{{ $product->created_at }}</th>
                                    <td>{{ $product->consecutivo }} - {{ $product->factura_proveedor }}</td>
                                    <td>{{ $product->cliente }}</td>
                                    <td>{{ $product->Codigo }}</td>
                                    <td>{{ $product->Detalle }}</td>
                                    <td>{{ money($product->purchase_price, '', 0) }}</td>
                                    
                                  
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
                <a href="/reports/products/purchased" class="btn btn-primary" role="button">Regresar</a>
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
