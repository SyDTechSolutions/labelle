@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Editar Moneda</div>

                <div class="card-body">
                    <form action="{{ url('currencies/'. $currency->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        @include('currencies.partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection