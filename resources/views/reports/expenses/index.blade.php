@extends('layouts.app')
@section('header')
<link rel="stylesheet" href="/css/flatpickr.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Gastos</div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/reports/expenses" method="GET">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="search" class="form-control input-sm" placeholder="Buscar..." name="q" value="{{ $search['q'] }}">
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
                               <div class="col-sm-3">
                                    <select class="form-control custom-select" name="impuesto" id="impuesto">
                                        <option value="">-- Impuesto --</option>
                                        <option value="1.130" {{ isset($search['impuesto']) && $search['impuesto'] == '1.130' ? 'selected' : ''}} >IVA 13%</option>
                                        <option value="1.040" {{ isset($search['impuesto']) && $search['impuesto'] == '1.040' ? 'selected' : ''}}>IVA 4%</option>
                                        <option value="1.020" {{ isset($search['impuesto']) && $search['impuesto'] == '1.020' ? 'selected' : ''}}>IVA 2%</option>
                                        <option value="1.010" {{ isset($search['impuesto']) && $search['impuesto'] == '1.010' ? 'selected' : ''}}>IVA 1%</option>
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