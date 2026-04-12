@extends('layouts.app')
@section('header')
<link rel="stylesheet" href="/css/flatpickr.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Cuentas por Pagar </div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/cxp" method="GET">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="search" class="form-control input-sm" placeholder="Buscar..." name="q" value="{{ $search['q'] }}">
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
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Condicion Venta</th>
                                    <th scope="col">Acciones</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $providerIds=[] @endphp
                                @foreach($purchases as $purchase)
                                @if($purchase->CondicionVentaName != 'Contado' && !in_array($purchase->provider_id,$providerIds) )
                                <tr class="{{ ($purchase->PlazoCredito && Illuminate\Support\Carbon::parse($purchase->PlazoCredito)->lessThan( Illuminate\Support\Carbon::now() )) ? 'table-danger': '' }}">
                                    <th><a href="/cxp/{{ $purchase->id }}">{{ $purchase->cliente }}</a></th>
                                    <td>{{ $purchase->CondicionVentaName }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="oi oi-ellipses"></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="/cxp/{{ $purchase->id }}">Ver Facturas</a>
                                               
                                            </div>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                @php array_push($providerIds,$purchase->provider_id) @endphp 
                                @endif
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
</script>
@endsection 