@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Impuestos </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/taxes" method="GET">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <label>Buscar: <input type="search" class="form-control input-sm" placeholder="" name="q" value="{{ $search['q'] }}"></label>
                                    </div>
                                    <div class="col-sm-6">
                                    
                                    </div>
                                </div>
                            </form>
                    </div>
                    <a href="/taxes/create" class="btn btn-success btn-sm">Crear</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tarifa</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($taxes as $tax)
                            
                                <tr>
                                    <th scope="row">{{ $tax->code }}</th>
                                    <td><a href="/taxes/{{ $tax->id }}/edit">{{ $tax->name }}</a></td>
                                    <td>{{ percent($tax->tarifa) }}</td>
                                    <td>
                                        @can('update', $tax)
                                        <form method="POST" action="{{ url('taxes/'. $tax->id) }}" data-confirm="Estas Seguro?">
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
                                   @if ($taxes)
                                    <td  colspan="6" class="pagination-container">{!!$taxes->appends(['q' => $search['q']])->render()!!}</td>
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