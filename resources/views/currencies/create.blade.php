@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Crear Moneda</div>

                <div class="card-body">
                    <form action="{{ url('currencies') }}" method="POST">
                        @csrf
                        @include('currencies.partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection