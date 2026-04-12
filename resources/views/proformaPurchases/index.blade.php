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
                        <span class="flex">Proformas de compras</span>
                        <div class="actions">

                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/proformapurchases" method="GET">
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
                    <a href="/proformapurchases/create" class="btn btn-success btn-sm">Crear Proforma de compra</a>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Consecutivo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Factura Proveedor</th>
                                    <th scope="col">Condicion Venta</th>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proformapurchases as $proformapurchase)

                                <tr>
                                    <th scope="row"><a href="/proformapurchases/{{ $proformapurchase->id }}">{{ $proformapurchase->consecutivo }}</a></th>
                                    <td>{{ $proformapurchase->created_at }}</td>
                                    <td><a href="/proformapurchases/{{ $proformapurchase->id }}">{{ $proformapurchase->cliente }}</a></td>
                                    <td>{{ $proformapurchase->factura_proveedor }}</td>
                                    <td>{{ $proformapurchase->CondicionVentaName }}</td>

                                    <td>{{ money($proformapurchase->TotalComprobante) }}</td>

                                    <td>
                                        @can('update', $proformapurchase)
                                        <form method="POST" action="{{ url('proformapurchases/'. $proformapurchase->id) }}" data-confirm="Estas Seguro?">
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
                                @if ($proformapurchases)
                                <td colspan="6" class="pagination-container">{!!$proformapurchases->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end']])->render()!!}</td>
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