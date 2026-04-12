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
                        <span class="flex">Gastos</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/expenses" method="GET">
                                <div class="row">
                                    <div class="col-sm-3">
                                   <input type="search" class="form-control input-sm" placeholder="Buscar..." name="q" value="{{ $search['q'] }}">
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
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                          <button type="submit" class="btn btn-info">Buscar</button> 
                                        </div> 
                                    </div>
                                </div>
                            </form>
                    </div>
                    <a href="/expenses/create" class="btn btn-success btn-sm">Crear Gasto</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Metodo Pago</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($expenses as $expense)
                            
                                <tr>
                                    <th scope="row"><a href="/expenses/{{ $expense->id }}">{{ $expense->id }}</a></th>
                                    <td>{{ $expense->date }}</td>
                                    <td><a href="/expenses/{{ $expense->id }}">{{ $expense->referencia }}</a></td>
                                    <td>{{ $expense->MedioPagoName }}</td>
                        
                                    <td>{{ money($expense->amount) }}</td>
                                    <td>{{ $expense->observations }}</td>
                                    <td>
                                       @can('update', $expense)
                                        <form method="POST" action="{{ url('expenses/'. $expense->id) }}" data-confirm="Estas Seguro?">
                                            @csrf
                                            {{ method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger btn-sm waves-effect">
                                                Eliminar
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                    
                                </tr>
                            @endforeach
                                   @if ($expenses)
                                    <td  colspan="7" class="pagination-container">{!!$expenses->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end']])->render()!!}</td>
                                @endif
                            
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

</script>
@endsection