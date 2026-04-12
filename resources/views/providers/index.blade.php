@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Proveedores </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/providers" method="GET">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <label>Buscar: <input type="search" class="form-control input-sm" placeholder="" name="q" value="{{ $search['q'] }}"></label>
                                    </div>
                                    <div class="col-sm-6">
                                    
                                    </div>
                                </div>
                            </form>
                    </div>
                    <a href="/providers/create" class="btn btn-success btn-sm">Crear</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Télefono</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($providers as $provider)
                            
                                <tr>
                                    <th scope="row">{{ $provider->id }}</th>
                                    <td><a href="/providers/{{ $provider->id }}/edit">{{ $provider->name }}</a></td>
                                    <td>{{ $provider->email }}</td>
                                    <td>{{ $provider->phone }}</td>
                                    <td>{{ $provider->description }}</td>
                                   <td>{{ $provider->address }}</td>
                                    <td>
                                        @can('update', $provider)
                                        <form method="POST" action="{{ url('providers/'. $provider->id) }}" data-confirm="Estas Seguro?">
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
                                   @if ($providers)
                                    <td  colspan="6" class="pagination-container">{!!$providers->appends(['q' => $search['q']])->render()!!}</td>
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