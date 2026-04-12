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
                        <span class="flex">Caja</span>   
                        <div class="actions">
                          
                        </div>
                  </div>  
                   
                </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/caja" method="GET">
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
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Consecutivo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Tipo Documento</th>
                                    <th scope="col">Condicion Venta</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            @foreach($proformas as $proforma)
                            @if($proforma->status==0)
                                <tr>
                                    <th scope="row">{{ $proforma->consecutivo }}</th>
                                    <td>{{ $proforma->created_at }}</td>
                                    <td>{{ $proforma->cliente }}</td>
                                    <td>{{ $proforma->TipoDocumentoName }}</td>
                                    <td>{{ $proforma->CondicionVentaName }}</td>
                        
                                    <td>{{ money($proforma->TotalComprobante) }}</td>
                                    
                                    <td>
                                        @can('update', $proforma)
                                        <form method="POST" action="{{ url('caja/'. $proforma->id) }}" data-confirm="Estas Seguro?">
                                            @csrf
                                            {{ method_field('DELETE')}}
                                            <button type="submit" class="btn btn-danger btn-sm waves-effect">
                                                Eliminar
                                            </button>
                                        </form>
                                        @endcan
                                        <form class='my-1'>
                                            @csrf
                                            <a href="/invoices/create?p={{$proforma->id}}?c=1" class="btn btn-success btn-sm waves-effect">Facturar</a>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                            @endforeach
                            
                                @if ($proformas)
                                    <td  colspan="6" class="pagination-container">{!!$proformas->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end'], 'created_by' => $search['created_by']])->render()!!}</td>
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