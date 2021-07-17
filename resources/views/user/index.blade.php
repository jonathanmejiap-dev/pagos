@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Lista de usuarios') }}</div>

                    <div class="card-body">


                        @include('custom.mensaje')

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">nombre</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role(s)</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                {{--$user->roles[0]--}}
                                    <tr>
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @isset($user->roles[0]->name)
                                                {{$user->roles[0]->name}}
                                            @endisset
                                        </td>
                                        <td>
                                            @can('view', [$user, ['user.show', 'userown.show']])
                                            <a class="btn btn-info" href="{{ route('user.show', $user->id) }}">Ver</a>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('view', [$user, ['user.edit', 'userown.edit']])
                                            <a class="btn btn-success" href="{{ route('user.edit', $user) }}">Editar</a>
                                            @endcan
                                        </td>
                                        <td>
                                            @can('haveaccess', 'user.destroy')
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
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
