@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Clientes </div>

                <div class="card-body">

                    <div class="filters">

                        <form action="/customers" method="GET">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Buscar: <input type="search" class="form-control input-sm" placeholder="" name="q" value="{{ $search['q'] }}"></label>
                                </div>
                                <div class="col-sm-6">

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="buttons level">
                      <div class="flex">
                         <a href="/customers/create" class="btn btn-success btn-sm">Crear</a>
                      </div>
                     <form class='mr-2' action="/customers/export" method="POST">
                            @csrf
                             <div class="form-row">
                                <button type="submit" class="btn btn-secondary btn-sm">Exportar</button>
                             </div>
                             
                    </form>
                    <form action="/customers/import"  method="POST" enctype="multipart/form-data">
                        @csrf
                         <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#upload">Importar</a>

                         <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Subir Archivo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="form-group">
                                            <label for="archivo">Archivo excel o csv</label>
                                            <input type="file" name='archivo' class="form-control-file">
                                            <button type="submit" class="btn btn-primary my-2">Subir</button>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </div>
                            </div>
                          </div>
                        </form>
                    
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Télefono</th>
                                    <th scope="col">Categoría</th>
                                    <!-- <th scope="col">Dirección</th> -->
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)

                                <tr>
                                    <th scope="row">{{ $customer->id }}</th>
                                    <td><a href="/customers/{{ $customer->id }}/edit">{{ $customer->name }}</a></td>
                                    <td>{{ $customer->email }} | {{ $customer->email2 }}</td>
                                    <td>{{ $customer->phone }} | {{ $customer->phone2 }}</td>
                                    <td>{{ $customer->category }}</td>
                                    <!-- <td>{{ $customer->address }}</td> -->
                                    <td>
                                        @can('update', $customer)
                                        <form method="POST" action="{{ url('customers/'. $customer->id) }}" data-confirm="Estas Seguro?">
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
                                @if ($customers)
                                <td colspan="6" class="pagination-container">{!!$customers->appends(['q' => $search['q']])->render()!!}</td>
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