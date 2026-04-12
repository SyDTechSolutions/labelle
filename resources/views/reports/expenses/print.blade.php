
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
                <h2>Reporte de gastos</h2>
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Referencia</th>
                            <th scope="col">Metodo Pago</th>
                            <th scope="col">IVA 1%</th>
                            <th scope="col">IVA 2%</th>
                            <th scope="col">IVA 4%</th>
                            <th scope="col">IVA 13%</th>
                            <th scope="col">Total IVA</th>
                            <th scope="col">Total</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gastos as $x=>$i)
                        <tr>
                            <th scope="row">{{$gastos[$x]['fecha']}}</th>
                            <td>{{$gastos[$x]['referencia']}}</td>
                            <td>{{$gastos[$x]['metodoPago']}}</td>
                            <td>{{$gastos[$x]['Iva1']}}</td>
                            <td>{{$gastos[$x]['Iva2']}}</td>
                            <td>{{$gastos[$x]['Iva4']}}</td>
                            <td>{{$gastos[$x]['Iva13']}}</td>
                            <td>{{$gastos[$x]['totalIva']}}</td>
                            <td>{{$gastos[$x]['total']}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="7"></td>
                            <td>
                                <b>Impuestos: {{ money($totalTaxes) }}</b> <br> 
                            </td>
                            <td>
                                <b>Total: {{ money($total) }}</b> <br> 
                            </td>
                            
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
                <a href="/reports/expenses" class="btn btn-primary" role="button">Regresar a Reportes</a>
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
