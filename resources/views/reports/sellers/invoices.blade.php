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
                        <span class="flex">Reporte Facturas por Vendedor</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/reports/sellers/invoices" method="GET">
                                <div class="row">
                                <div class="col-sm-3">
                                           
                                           <div class="input-group mb-3 flatpickr">
                                               <input data-input type="text" name="start" class="form-control" placeholder="Desde" value="{{ $search['start'] }}">
                                               <div class="input-group-append">
                                                   <span class="input-group-text" data-clear><i class="oi oi-circle-x"></i></span>
                                               </div>
                                           </div>
                                          
                                     
                                   
                                     
                                   </div>
                                    <div class="col-sm-3">
                                       
                                         <div class="input-group mb-3 flatpickr">
                                                <input data-input type="text" class="form-control" placeholder="Hasta" name="end" value="{{ $search['end'] }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" data-clear><i class="oi oi-circle-x"></i></span>
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                          <button type="submit" class="btn btn-info">Generar</button>
                                          <button type="button" class="btn btn-secondary btn-print">Imprimir</button>
                                          <input type="hidden" name="print" value="0">  
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </form>
                    </div>
                   
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Vendedor</th>
                                    <th scope="col"># Facturas</th>
                                    <th scope="col">Monto Total</th>
                                   
                                    <th scope="col">% Comisión</th>
                                    <th scope="col">Monto Comisión</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($sellers as $seller)
                                
                                    
                                    <tr is="seller-tr" :seller="{{ json_encode($seller) }}"></tr>
                                    
                                   
                                   
                               
                            @endforeach
                         
                            
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
       

    </script>
@endsection