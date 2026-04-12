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
                        <span class="flex">Reporte Facturas por Cliente</span>
                        <div class="actions">

                        </div>
                    </div>

                </div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/reports/customers/invoices" method="GET">
                            <div class="row">
                                <div class="col-sm-3">

                                    <div class="input-group mb-3 flatpickr">
                                        <input data-input type="text" name="start" class="form-control"
                                            placeholder="Desde" value="{{ $search['start'] }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-clear><i
                                                    class="oi oi-circle-x"></i></span>
                                        </div>
                                    </div>




                                </div>
                                <div class="col-sm-3">

                                    <div class="input-group mb-3 flatpickr">
                                        <input data-input type="text" class="form-control" placeholder="Hasta"
                                            name="end" value="{{ $search['end'] }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" data-clear><i
                                                    class="oi oi-circle-x"></i></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info">Generar</button>
                                        <button type="button" class="btn btn-secondary btn-print">Imprimir</button>
                                        <input type="hidden" name="print" value="0">
                                        <input type="hidden" name="order" value="">
                                        <input type="hidden" name="dir" value="">
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
                                <th scope="col"><a href="/reports/customers/invoices?start={{ $search['start'] }}&end={{ $search['end'] }}&order=invoices_count&dir={{ $search['dir'] }}">
                                        # Facturas 
                                    @if($search['order'] == 'invoices_count')
                                        @if($search['dir'] == 'DESC')
                                            <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="with:30px;height:30px;"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></span>
                                        @else
                                            <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="with:30px;height:30px;"><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg></span>
                                        @endif
                                    @endif
                                    </a></th>
                                    <th scope="col"><a href="/reports/customers/invoices?start={{ $search['start'] }}&end={{ $search['end'] }}&order=invoices_total&dir={{ $search['dir'] }}">
                                        Monto Total
                                        @if($search['order'] == 'invoices_total')
                                            @if($search['dir'] == 'DESC')
                                                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="with:30px;height:30px;"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></span>
                                            @else
                                                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="with:30px;height:30px;"><path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z"/></svg></span>
                                            @endif
                                        @endif
                                    </a></th>



                                </tr>
                            </thead>
                            <tbody>
                                @isset($customers)


                                    @foreach($customers as $customer)

                                        <tr>

                                            <th scope="row">{{ $customer->name }}</th>
                                            <td>{{ $customer->invoices_count }}</td>
                                            <td>{{ money($customer->invoices_total) }}</td>




                                        </tr>






                                    @endforeach

                                @endisset
                            </tbody>
                        </table>
                        @isset($customers)
                            {{ $customers->appends(['start' => $search['start'], 'end' => $search['end'], 'order' => $search['order'], 'dir' => $search['dir']])->links() }}
                        @endisset
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
        $('input[name="order"]').val('{{ $search["order"] }}');
        $('input[name="dir"]').val('{{ $search["dir"] }}');

        $(this).parents('form').submit();
    })
</script>
@endsection