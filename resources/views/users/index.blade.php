@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">Usuarios </div>

                <div class="card-body">
                   
                    <div class="filters">
                     
                         <form action="/users" method="GET">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <label>Buscar: <input type="search" class="form-control input-sm" placeholder="" name="q" value="{{ $search['q'] }}"></label>
                                    </div>
                                    <div class="col-sm-6">
                                    
                                    </div>
                                </div>
                            </form>
                    </div>
                    <a href="/users/create" class="btn btn-success btn-sm">Crear</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Rol</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                            
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td><a href="/users/{{ $user->id }}/edit">{{ $user->name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td> 
                                        @foreach($user->roles as $role)
                                        {{ Illuminate\Support\Str::title($role->name) }}
                                        @endforeach
                                    </td>
                                <td>     
                                        <span class="badge badge-{{ trans('utils.status_user_color.'. $user->status) }}">{{ trans('utils.status_user.'. $user->status) }}</span>
                                    </td>
                                    <td>
                                        @can('update', $user)
                                        <form method="POST" action="{{ url('users/'. $user->id) }}" data-confirm="Estas Seguro?">
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
                                @if ($users)
                                    <td  colspan="6" class="pagination-container">{!!$users->appends(['q' => $search['q']])->render()!!}</td>
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