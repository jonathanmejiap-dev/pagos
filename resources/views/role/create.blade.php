@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Crear Rol</h2>
                    </div>

                    <div class="card-body">
                       @include('custom.mensaje')

<h4>Información requerida</h4>
                        <form action="{{ route('role.store') }}" method="POST">
                            @csrf
                            <div class="container">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Nombre" value="{{old('name')}}">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="slug" value="{{old('slug')}}" class="form-control" id="Slug"
                                        placeholder="slug">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" placeholder="Descripción" id="description" rows="3">{{old('description')}}</textarea>
                                </div>
                            </div>

                            <hr>
                            <h4>Acceso full</h4>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="accessfullyes" name="full_access" value="yes" class="custom-control-input"
                                    @if(old('full_access') == 'yes') checked @endif
                                >
                                <label class="custom-control-label" for="accessfullyes" >Si</label>
                              </div>
                              <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="accessfullno" name="full_access" value="no" class="custom-control-input" 
                                    @if(old('full_access') == 'no') checked @endif
                                    @if(old('full_access') === null) checked @endif
                                >
                                <label class="custom-control-label" for="accessfullno">No</label>
                              </div>

                            <hr>
                            <h4>Lista de permisos</h4>
                            @foreach($permissions as $permission)
                            <div class="custom-control custom-checkbox">
                                <input 
                                    type="checkbox" 
                                    class="custom-control-input" 
                                    id="permission_{{$permission->id}}"
                                    value="{{$permission->id}}"
                                    name="permission[]"
                                    @if(is_array(old('permission')) && in_array("$permission->id", old('permission')))
                                        checked
                                    @endif
                                >
                                <label class="custom-control-label" for="permission_{{$permission->id}}">
                                    {{$permission->id}}
                                    -
                                    {{$permission->name}}
                                    <em>( {{$permission->description}} )</em>
                                </label>
                              </div>
                            @endforeach
                            <hr>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
