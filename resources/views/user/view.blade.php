@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Ver Rol</h2>
                    </div>

                    <div class="card-body">
                       @include('custom.mensaje')

<h4>Información requerida</h4>
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="container">
                                <div class="form-group">
                                    <input disabled type="text" name="name" class="form-control" id="name"
                                        placeholder="Nombre" value="{{old('name', $user->name)}}">
                                </div>
                                <div class="form-group">
                                    <input disabled type="email" name="email" value="{{old('slug', $user->email)}}" class="form-control" id="Slug"
                                        placeholder="slug">
                                </div>
                                
                                <div class="form-group">
                                    <select name="roles" id="roles" class="form-control mb-3">
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}"
                                           @isset($user->roles[0]->name)
                                                @if($role->name == $user->roles[0]->name)
                                                selected
                                                @endif
                                           @endisset
                                           >{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                               
                            </div>

                            <hr>
                            <a href="{{route('user.edit', $user->id)}}" class="btn btn-primary">Editar</a>
                            <a href="{{route('user.index')}}" class="btn btn-secondary">Volver</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
