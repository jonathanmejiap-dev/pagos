@extends('plantilla')
@section('titulo', 'CONTROL DE PAGOS -IESTP SDM')

@section('contenido')
    <div class="container">
        <div class="py-2 text-center">

            {{-- <div class="title m-b-md font-weight-bold">
                CONTROL DE PAGOS
            </div> --}}
            <h1>CONTROL DE PAGOS</h1>
            <p class="lead">En este apartado podras precisar, los pagos realizados por trámites en el <b
                    class="font-weight-bold">IESTP Señor de la divina misericordia</b>.</p>
        </div>

        <div class="row">
            <div class="col-md-8 order-md-1 py-4">
                <div class="card">
                    <div class="card-header text-white bg-primary ">
                        <h4 class="font-weight-bold pt-2">Pago del trámite</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pago.store') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="font-weight-bold text-primary">Datos del usuario</h4>
                                </div>
                                <div class="col-md-4  mb-3">
                                    <label for="username" class="font-weight-bold">DNI</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control @error('dni') is-invalid @enderror"
                                            name="dni" id="dni" value="{{ old('dni') }}" placeholder="78485965"
                                            required="required">
                                        @error('dni')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label for="nombres" class="font-weight-bold">Nombres y apellidos</label>
                                    <input type="text" class="form-control @error('nombres') is-invalid @enderror"
                                        name="nombres" id="nombres" placeholder="Marco Rojas Noriega"
                                        value="{{ old('nombres') }}" required>
                                    <small class="text-muted">Nombres y apellidos completos.</small>
                                    @error('nombres')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label for="telefono" class="font-weight-bold">Teléfono</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                            value="{{ old('telefono') }}" name="telefono" id="telefono"
                                            placeholder="923121314" required>
                                        @error('telefono')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label for="email" class="font-weight-bold">Email <span
                                            class="text-muted">(Opcional)</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control " value="{{ old('email') }}" name="email"
                                            id="email" placeholder="tu@correo.com">

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h4 class="font-weight-bold text-success">Datos del pago</h4>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12 mb-3">
                                    <label for="tramite" class="font-weight-bold">Trámite a realizar (Concepto)</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-crosshairs"></i></span>
                                        </div>
                                        <select class="form-control @error('tramite') is-invalid @enderror" name="tramite"
                                            id="tramite">
                                            <option value="">Seleccionar</option>
                                            @foreach ($tupas as $tupa)
                                                <option @if (old('tramite') == $tupa->id) {{ 'selected' }} @endif
                                                    value="{{ $tupa->id }}">{{ $tupa->nombre }} | <b>S/.
                                                        {{ $tupa->monto }}</b></option>
                                            @endforeach
                                        </select>
                                        @error('tramite')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror

                                        {{-- <input type="hidden" name="valor_monto" class="valor_monto" value="{{ $tupa->monto }}"> --}}
                                    </div>
                                    <small class="text-muted">Seleccionar el trámite que usted realizará.</small>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="operacion" class="font-weight-bold">N° operación <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="text" class="form-control @error('operacion') is-invalid @enderror"
                                            value="{{ old('operacion') }}" name="operacion" id="operacion"
                                            placeholder="2584582">
                                        @error('operacion')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="monto" class="font-weight-bold">Monto <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text font-weight-bold">S/.</span>
                                        </div>
                                        <input type="text" class="form-control @error('monto') is-invalid @enderror"
                                            name="monto" id="monto" placeholder="200.00" value="{{ old('monto') }}">
                                        @error('monto')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="archivo" class="font-weight-bold">Adjuntar captura del voucher <span
                                            class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="archivo" value="{{ old('archivo') }}"
                                            class="custom-file-input @error('archivo') is-invalid @enderror"
                                            id="customFile">
                                        <label class="custom-file-label" for="customFile">Seleccionar archivo</label>
                                    </div>
                                    @error('archivo')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <hr class="mb-4">

                            <h4 class="mb-3">Confirmar</h4>

                            <div class="d-block my-3 mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                        class="custom-control-input @error('check_ok') is-invalid @enderror" id="check_ok"
                                        name="check_ok" <?php if (old('check_ok')=='on' ) { echo 'checked' ;
                                        }?>  />
                                    <label class="custom-control-label" for="check_ok">Confirma que todos los datos
                                        registrados, son reales, en caso contrario, atenerse a las restriccioes de las
                                        politicas de privacidad del sitio.</label>
                                    <small class="text-muted">En caso de no ser validos los datos, se bloqueara el envio de
                                        pagos del usuario registrado.</small>
                                    @error('check_ok')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit">Enviar pago realizado</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center pt-4 mb-3">
                    <span class="text-muted font-weight-bold">Datos del banco</span>
                    <span class="badge badge-danger badge-pill small" style="font-size:12px">Importante!!</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0 font-weight-bold"><i class="fas fa-university "></i> Banco de la nación</h6>
                            <small class="text-muted">Transacciones Banco | Agentes</small>
                        </div>
                        <span class="text-muted">S/.</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed bg-light">
                        <div>
                            <h6 class="my-0 font-weight-bold">Nombre: IESTP Señor de la Divina Misericordia</h6>
                            <small class="text-muted">Revisar nombre al hacer la transacción</small>
                        </div>
                        {{-- <span class="text-muted">$5</span> --}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed bg-success text-white">
                        <div>
                            <h6 class="my-0 font-weight-bold"># Cuenta Ahorros: 0729585482</h6>
                            <small class="text-light font-weight-bold">En soles</small>
                        </div>
                        {{-- <span class="text-muted">$8</span> --}}
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="font-weight-bold">Consultar operación registrada</h6> <i
                                    class="fas fa-share"></i>
                            </div>
                        </div>
                        <form action="" method="POST" class="row">
                            @csrf

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fab fa-keycdn"></i></span>
                                </div>
                                <input type="text" name="op" id="op" class="form-control" placeholder="# Operación">
                            </div>
                            <button type="button" class="btn btn-primary btn-block" id="consulta" data-toggle="modal"
                                data-target="#consultarOPModal">
                                Consultar
                            </button>
                        </form>


                        <!-- Modal CONSULTA-->
                        <div class="modal fade" id="consultarOPModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Consulta PAGO REGISTRADO</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <h2>#OP: <b id="txt_op"></b></h2>
                                                <h2>Monto: S/.<b id="txt_monto"></b></h2>

                                            </div>
                                            <div class="col-lg-4">
                                                <button type="button" class="btn btn-primary btn-block">
                                                    Estado: <span class="badge badge-light" id="txt_estado">4</span>
                                                </button>
                                                <br>
                                                <b>DNI:</b><span id="txt_dni"></span>
                                                
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12" >
                                                <b>Mensaje:</b>
                                               
                                                <div class="alert my-2" role="alert" id="mensaje_color">
                                                    <span id="txt_mensaje"></span>
                                                  </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cer">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <span>------------</span>
                        <strong>-----------</strong> --}}
                    </li>
                </ul>

                {{-- <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </div>
                </form> --}}

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="https://isdm.edu.pe/transparencia" target="_blank" class="link"><i
                                        class="fas fa-eye"></i> <b>(TUPA)</b> Texto Unico de
                                    Procedimientos Administrativos </a>
                                <br>
                                <small class="text-muted">El pago se hace de acuerdo al TRÁMITE establecido en el
                                    TUPA</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>





        </div>


    </div>

@endsection

@push('scripts')
    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        // $("#tramite").change(function() {
        //     var valor_monto = $(".valor_monto").val()
        //     alert("Handler for .change() called."+valor_monto);
        // });
    </script>


    <script type="text/javascript">
        function actualizar() {
            location.reload(true);
        }
        $(document).ready(function() {

            

            function contadorNuevosTramites() {
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var codigo = $("#op").val();
                // alert('codigo'+codigo);
                var estado='';
                var color='';
                $.ajax({
                    type: "post",
                    url: "{{ route('pago.consulta_ajax') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        codigo: codigo
                    },
                    success: function(data) {
                        // alert("Se ha realizado el POST con exito " + data);
                        $("#txt_op").text(data.num_op);
                        
                        $("#txt_mensaje").text(data.mensaje);
                        $("#txt_dni").text(data.navegante_id);
                        $("#txt_monto").text(data.monto);

                        switch(data.estado){
                            case "0":
                                estado='Enviado';
                                color='alert-secondary';
                                break;
                            case "1":
                                estado='Aceptado';
                                color='alert-success';
                                break;
                            case "2":
                                estado='Rechazado';
                                color='alert-danger';
                                break;
                            case "3":
                                estado='Baja';
                                color='alert-warning';
                                break;
                        }

                        $("#txt_estado").text(estado);
                        $("#mensaje_color").addClass(color);
                        // $("#nuevos_tramites").text(data);
                        
                    }
                });
            }

            $('#cer').click(function () {
                $('#op').val("");
            })

           

            $('#consulta').click(function() {
                contadorNuevosTramites();
                
            });


        });
        //Función para actualizar cada 5 segundos(5000 milisegundos)
        //setInterval("actualizar()", 5000);
    </script>

    @if (Session::has('error'))
        <script type="text/javascript">
            function actualizar() {
                location.reload(true);
            }
            //Función para actualizar cada 5 segundos(5000 milisegundos)
            //setInterval("actualizar()",5000);
            Swal.fire({
                title: 'Registros no encontrados?',
                text: "Lo sentimos, no se encontraron registros de trámites en nuestra institución.",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Cancelar'
            })
        </script>
    @endif

    @if (Session::has('estado') == 'registro_ok')
        <script type="text/javascript">
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Pago registrado correctamente.',
                showConfirmButton: true,
                timer: 2500
            })
        </script>
    @endif
@endpush
