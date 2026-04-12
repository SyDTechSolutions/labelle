@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Monedas </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/currencies" method="GET">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <label>Buscar: <input type="search" class="form-control input-sm" placeholder="" name="q" value="{{ $search['q'] }}"></label>
                                    </div>
                                    <div class="col-sm-6">
                                    
                                    </div>
                                </div>
                            </form>
                    </div>
                    <a href="/currencies/create" class="btn btn-success btn-sm">Crear</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Simbolo</th>
                                    <th scope="col">Tipo Cambio</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($currencies as $currency)
                            
                                <tr>
                                    <th scope="row">{{ $currency->code }}</th>
                                    <td><a href="/currencies/{{ $currency->id }}/edit">{{ $currency->name }}</a></td>
                                    <td>{{ $currency->symbol }}</td>
                                    <td>{{ $currency->exchange }}</td>
                                    <td>
                                        @can('update', $currency)
                                        <form method="POST" action="{{ url('currencies/'. $currency->id) }}" data-confirm="Estas Seguro?">
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
                                   @if ($currencies)
                                    <td  colspan="6" class="pagination-container">{!!$currencies->appends(['q' => $search['q']])->render()!!}</td>
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