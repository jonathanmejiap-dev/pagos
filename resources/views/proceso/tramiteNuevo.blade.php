@extends('plantilla')
@section('titulo', 'MESA DE PARTES')

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    @endpush

@section('contenido')
    <div class="pt-2 mt-2">
        <div class="row">
            <div class="col-md-12">
                <h1>Registrar trámite</h1>
            </div>
        </div>

        <div class="row">

            <form class="col-md-12 needs-validation" action="{{ route('proceso.registrar.nuevo') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-header text-white bg-primary">
                        <h3>Datos del solicitante</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dni">DNI</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="dni" class="form-control" id="dni"
                                        value="{{ $navegante->dni }}" placeholder="DNI" required="">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="firstName">Nombres y apellidos</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="nombres" id="firstName" placeholder=""
                                        value="{{ $navegante->nombres . ' ' . $navegante->apellidoPaterno . ' ' . $navegante->apellidoMaterno }}"
                                        required="">
                                </div>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username">Teléfono | Celular</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    </div>
                                    <input type="text" name="telefono" class="form-control" id="telefono"
                                        placeholder="923202020" required="" value="923905296">
                                    <div class="invalid-feedback" style="width: 100%;">
                                        Your username is required.
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>

                                    <input type="email" name="email" value="jonathan@gmail.com" class="form-control"
                                        id="email" placeholder="tucorreo@dominio.com">
                                </div>
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="direccion">Dirección <span class="text-muted">(Optional)</span></label>
                                <input type="text" name="direccion" value="Av. centenario #542 - Huaraz"
                                    class="form-control" id="direccion" placeholder="Jr. Atahualpa #298 - Ocros">
                                <div class="invalid-feedback">
                                    Please enter a valid email address for shipping updates.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Session::has('falta_archivo'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Seleccionar un archivo desde su equipo</strong> o cargarlo desde un medio compartido.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header text-white bg-success">
                        <h3>Trámite a solicitar</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    @php
                                        $tipo_documento = App\Tipo_documento::all();
                                    @endphp
                                    <label for="exampleFormControlSelect1">Tipo de documento:</label>
                                    <select class="form-control" name="tipo_documento" required
                                        id="exampleFormControlSelect1">
                                        <option value="">Seleccionar</option>
                                        @foreach ($tipo_documento as $tipoDoc)
                                            <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <label for="asunto">Asunto: <span class="text-danger">(Obligatorio)</span></label>
                                <input type="text" name="asunto" value="Solicito prácticas pre-profesionales"
                                    class="form-control" id="asunto"
                                    placeholder="Ejemplo: Solicito prácticas pre-profesionales">

                            </div>
                            <div class="col-md-2">

                                <label for="folios"># Folios: </label>
                                <input type="text" name="folios" value="5" class="form-control" id="asunto"
                                    placeholder="Ejemplo: 5">

                            </div>
                            <div class="col-md-12 mb-3">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                            aria-controls="home" aria-selected="true">Subir archivo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                            aria-controls="profile" aria-selected="false">Adjuntar desde la nube</a>
                                    </li>

                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        <div class="col-md-12 mb-3 mt-4">

                                            <div class="form-group">
                                                <label for="archivo">Seleccionar archivo:</label>
                                                <input type="file" class="form-control-file" name="archivo" id="archivo">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="col-md-12 mb-3 mt-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-edge"></i></span>
                                                </div>

                                                {{-- <label for="address">Address</label> --}}
                                                <input type="text" name="url"
                                                    value="https://getbootstrap.com/docs/4.6/utilities/shadows/"
                                                    class="form-control" id="address" placeholder="1234 Main St">
                                            </div>
                                            <div class="invalid-feedback">
                                                Please enter your shipping address.
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <hr class="mb-4">
                        <div class="row pb-4 mb-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary" type="submit">Enviar solicitud</button>
                                <button class="btn secondary">Cancelar</button>
                            </div>
                        </div>

            </form>


        </div>
    </div>
@endsection

@push('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $("#cancelar").click(function() {

                Swal.fire({
                    title: 'Desea cancelar el presente trámite?',
                    showDenyButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        window.location.replace("http://localhost/mesapartes/public");
                    }
                })
            });
        });
    </script>

@endpush
