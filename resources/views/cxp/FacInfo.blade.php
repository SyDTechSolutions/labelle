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

                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET">
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
                                        <button type="submit" class="btn btn-outline-info"><a href="/cxp">Regresar</a></button>
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
                                    <th scope="col">Factura Proveedor</th>
                                    <th scope="col">Condicion Venta</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Pendiente</th>
                                    <th scope="col">Vencimiento</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($purchases as $purchase)
                                @if($purchase->CondicionVentaName != 'Contado')
                                <tr class="{{ ($purchase->PlazoCredito && Illuminate\Support\Carbon::parse($purchase->PlazoCredito)->lessThan( Illuminate\Support\Carbon::now() )) ? 'table-danger': '' }}">
                                    <th scope="row"><a href="/purchases/{{ $purchase->id }}">{{ $purchase->consecutivo }}</a></th>
                                    <td>{{ $purchase->created_at }}</td>
                                    <td><a href="/purchases/{{ $purchase->id }}">{{ $purchase->cliente }}</a></td>
                                    <td>{{ $purchase->factura_proveedor }}</td>
                                    <td>{{ $purchase->CondicionVentaName }}</td>

                                    <td>{{ money($purchase->TotalComprobante) }}</td>
                                    <td><span class="text-danger">{{ money($purchase->cxp_pending_amount) }}</span></td>
                                    <td>{{ $purchase->PlazoCredito }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="oi oi-ellipses"></span>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="/cxp/{{ $purchase->id }}/payment" data-toggle="modal" data-target="#paymentsModal" data-purchase="{{ $purchase->id}}">Abonos</a>
                                                <a class="dropdown-item" href="/cxp/{{ $purchase->id }}/payment"  data-toggle="modal"
                                                    data-target="#cxpModal" data-customer="{{ $purchase->provider_id}}">Estado de cuenta</a>
                                               
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @if ($purchases)
                                <td colspan="9" class="pagination-container">{!!$purchases->appends(['q' => $search['q']])->render()!!}</td>
                                @endif

                            </tbody>
                        </table>
                        <div>
                            <h5><b>Total CXP:</b> {{ money($totalCompras) }}</h5>
                            <h5><b>Total Pendiente:</b> {{ money($totalPendiente) }}</h5>
                        </div>
                        <purchase-payments-modal></purchase-payments-modal>
                        <cxp-modal></cxp-modal>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('#paymentsModal').on('show.bs.modal', function(e) {

        var button = $(e.relatedTarget)
        var purchase_id = button.attr('data-purchase');

        window.events.$emit('showPaymentsModal', purchase_id);
    })
    $('#cxpModal').on('show.bs.modal', function (e) {

        var button = $(e.relatedTarget)
        var provider_id = button.attr('data-customer');

        window.events.$emit('showCxpModal', provider_id);
    })
</script>
@endsection 