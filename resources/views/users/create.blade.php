@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Crear Usuario</div>

                <div class="card-body">
                    <form action="{{ url('users') }}" method="POST">
                        @csrf
                        @include('users.partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection