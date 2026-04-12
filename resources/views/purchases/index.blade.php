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
                        <span class="flex">Facturas de compras</span>
                        <div class="actions">

                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/purchases" method="GET">
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
                    <a href="/purchases/create" class="btn btn-success btn-sm">Crear Factura de compra</a>
                   
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
                                @foreach($purchases as $purchase)

                                <tr>
                                    <th scope="row"><a href="/purchases/{{ $purchase->id }}">{{ $purchase->consecutivo }}</a></th>
                                    <td>{{ $purchase->created_at }}</td>
                                    <td><a href="/purchases/{{ $purchase->id }}">{{ $purchase->cliente }}</a></td>
                                    <td>{{ $purchase->factura_proveedor }}</td>
                                    <td>{{ $purchase->CondicionVentaName }}</td>

                                    <td>{{ money($purchase->TotalComprobante) }}</td>

                                    <td>
                                        @can('update', $purchase)
                                        <form method="POST" action="{{ url('purchases/'. $purchase->id) }}" data-confirm="Estas Seguro?">
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
                                @if ($purchases)
                                <td colspan="7" class="pagination-container">{!!$purchases->appends(['q' => $search['q'],'start' => $search['start'], 'end' => $search['end']])->render()!!}</td>
                                @endif

                            </tbody>
                        </table>
                        <div>
                            <h5><b>Total Compras:</b> {{ money($totalCompras) }}</h5>
                          
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 