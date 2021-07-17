@extends('layouts.admin')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Roles</h1>
    {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}

</div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Lista de roles') }}</div>

                    <div class="card-body">
                        @can('haveaccess','role.create')
                        <a href="{{ route('role.create') }}" class="btn btn-primary float-right">Crear</a>
                        <br><br>
                        @endcan
                        
                        @include('custom.mensaje')

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">nombre</th>
                                    <th scope="col">url</th>
                                    <th scope="col">descripción</th>
                                    <th scope="col">Acceso full</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <th scope="row">{{ $role->id }}</th>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->slug }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>{{ $role['full_access'] }}</td>
                                        <td>
                                            @can('haveaccess','role.show')
                                            <a class="btn btn-info" href="{{ route('role.show', $role->id) }}">Ver</a>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('haveaccess','role.edit')
                                            <a class="btn btn-success" href="{{ route('role.edit', $role) }}">Editar</a>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('haveaccess','role.destroy')
                                            <form action="{{ route('role.destroy', $role->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
