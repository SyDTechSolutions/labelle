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
                        <span class="flex">Reporte Confirmar Documentos</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/reports/receptors" method="GET">
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                          <button type="submit" class="btn btn-info">Generar</button>
                                          <button type="button" class="btn btn-secondary btn-export">Exportar</button>
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
                                    <th scope="col">Documento</th>
                                    <th scope="col">Tipo Documento</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Nombre Receptor</th>
                                    <th scope="col">Cédula Receptor</th>
                                    <th scope="col">Moneda</th>
                                    <th scope="col">Condición Venta</th>
                                    <th scope="col">Total Impuesto</th>
                                    <th scope="col">Total Factura</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($receptors as $receptor)
                                <tr>
                                    <th scope="row">{{ $receptor->NumeroConsecutivoReceptor }}</th>
                                    <td>{{ $receptor->tipoDocumentoName }}</td>
                                    <td>{{ $receptor->created_at }}</td>
                                    <td>{{ $receptor->NumeroCedulaEmisor }}</td>
                                    <td>{{ $receptor->nombre_emisor }}</td>
                                    <td>{{ $receptor->CodigoMoneda }}</td>
                                    <td>{{ $receptor->CondicionVentaName }}</td>
                                    <td>{{ $receptor->MontoTotalImpuesto }}</td>
                                    <td>{{ $receptor->TotalFactura }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>      

                   </div>
                   <div class="row">
                    <div class="col-md-9">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
    
         $('.btn-export').on('click', function (e) {
             
             $('input[name="export"]').val(1);

             $(this).parents('form').submit();

             $('input[name="export"]').val(0);
         })
       

    </script>
@endsection