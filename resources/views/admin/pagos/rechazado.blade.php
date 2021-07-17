@extends('layouts.admin')
@push('styles')


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
    @php
    $suma = 0;
    $contador = 0;
    foreach ($pagos as $pago) {
        $suma += $pago->monto;
        $contador++;
    }
    @endphp
    <div class="mb-4 card">
        <div class="card-body d-sm-flex align-items-center justify-content-between ">
        <h1 class="h3 mb-0 text-danger font-weight-bold"><i class="fas fa-ban"></i> Pagos rechazados<br><small class="text-danger">Lista de pagos rechazados.</small>
        </h1>


        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Monto rechazado: </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            S/.{{ number_format($suma, 2) }}
                        </div>
                    </div>
                    <div class="col-auto">

                        <i class="fas fa-cash-register fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total rechazados: </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $contador }}
                        </div>
                    </div>
                    <div class="col-auto">

                        <i class="fas fa-file-contract fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('home') }}" class="btn btn-sm btn-light shadow-sm">
            <i class="fas fa-check-circle text-white-50"></i> Página principal <i class="fas fa-house-user"></i></a>
        </div>
    </div>



    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            {{-- <h3>Lista de trámites permitidos</h3> --}}
            <table id="tipodocedientes" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th># Operación</th>
                        <th>TUPA</th>
                        <th>Monto Rechazado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="font-weight-bold"><i class="fas fa-key"></i> {{ $pago->num_op }}</td>
                            <td>
                                <b class="text-primary">Procedimiento:</b> <b>{{ $pago->tupa->nombre }}</b>
                                <br>
                                <i class="fas fa-user"></i> {{$pago->navegante->nombres}} 
                                <br>
                                <b class="text-danger">S/. {{ $pago->tupa->monto }}</b>
                                {{-- Descargar archivo --}}
                                <a href="{{asset($pago->archivo) }}" class="btn btn-primary float-right btn-sm" target="_blank"
                                    title="Ver archivo adjunto">
                                    <i class="fas fa-file-download"></i>
                                </a>
                                {{-- Ver detalles --}}
                                <button type="button" class="btn btn-primary float-right btn-sm  mx-2" title="ver detalles"
                                    data-toggle="modal" data-target="#detalleUsuarioModal{{ $pago->id }}">
                                    <i class="fas fa-search"></i>
                                </button>

                                {{-- Modal detalles del navegante --}}
                                <!-- Modal -->
                                <div class="modal fade" id="detalleUsuarioModal{{ $pago->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                {{-- USUARIO --}}
                                                <div class="card mb-4">
                                                    <h5 class="card-header">Usuario: DNI {{ $pago->navegante->id }}</h5>
                                                    <div class="card-body">

                                                        <ul>
                                                            <li><b>Nombre: {{ $pago->navegante->nombres }}</b></li>
                                                            <li><b>Teléfono: {{ $pago->navegante->telefono }}</b></li>
                                                            <li><b>Email:</b> {{ $pago->navegante->email }}</li>
                                                            <li>
                                                                <b>Estado:</b>
                                                                @if ($pago->navegante->estado == '0')
                                                                    <span class="badge badge-success">Activo</span>
                                                                @else
                                                                    <span class="badge badge-danger">Bloqueado</span>
                                                                @endif
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </div>

                                                {{-- OPERACION --}}
                                                <div class="card">
                                                    <h5 class="card-header bg-success text-white"># Operación:
                                                        {{ $pago->num_op }}</h5>
                                                    <div class="card-body">
                                                        <h5 class="card-title"><b>Procedimiento:</b>
                                                            {{ $pago->tupa->nombre }}</h5>
                                                        <h5 class="card-title"><b>Monto depositado: </b>S/.
                                                            {{ number_format($pago->monto, 2) }}</h5>
                                                        <a href="{{asset($pago->archivo) }}" class="btn btn-primary btn-block" target="_blank">
                                                            <i class="fas fa-file-download"></i> Archivo adjunto
                                                        </a>

                                                        <small class="text-muted">Enviado: {{ $pago->created_at }}</small>
                                                        <div class="alert alert-light text-center" role="alert">
                                                            "{{ $pago->mensaje }}"
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td style="vertical-align: middle;" class="bg-danger text-white text-center font-weight-bold"><i
                                    class="fas fa-money-bill-alt"></i> S/. {{ $pago->monto }}</td>
                            <td style="vertical-align:middle;" class="text-center">
                                <span class="badge badge-danger">
                                    <i class="fas fa-check-circle"></i> <br>Rechazado
                                </span>
                                <br>
                                <small class="font-weight-bold">{{$pago->updated_at}}</small>
                                    
                            </td>

                            <td class="text-center">
                                {{-- CONFIRMAR PAGO
                                <a href="{{ route('admin.pago.confirmar', $pago) }}" class="btn btn-success btn-sm">
                                    <small> <i class="fas fa-check-circle"></i> Confirmar</small>
                                </a> --}}
                                {{-- BAGA DE PAGO --}}
                                <button class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#rechazarModal{{ $pago->id }}" title="Volver aceptar el pago">
                                    <small> <i class="fas fa-redo"></i> Re-confirmar</small>
                                </button>

                                <div class="modal fade" id="rechazarModal{{ $pago->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Re-confirmar</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.pago.actualizar', $pago) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <input type="hidden" name="estado" value="1">
                                                        <label for="mensaje">Mensaje de re-confirmación:</label>
                                                        <textarea class="form-control" id="mensaje" name="mensaje" rows="3"
                                                            required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Confirmar</button>

                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ELIMINAR PAGO 
                                <form method="POST" style="display:inline"
                                    action="{{ route('admin.pago.destroy', $pago) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger"
                                        onclick="return confirm('Estas seguro que deseas eliminar la publicación')">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModalCenter{{ $pago->id }}">
                                    <i class="fas fa-search"></i>
                                </button> --}}
                            </td>



                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Concepto</th>
                        <th># Operación</th>
                        <th>Monto Rechazado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
            </table>

        </div>



    </div>

    <!-- Content Row -->

    {{-- crear nuevo --}}
    <!-- Modal -->
    <div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear nuevo tipo de trámite</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.tipodocumento.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre del tipo de trámite:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresar nombre">
                            {{-- <small id="nombre" class="form-text text-muted">.</small> --}}
                        </div>

                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    {{-- *************VALIDACIONES************* --}}

    {{-- MENSAJES AL ELIMINAR --}}
    {{-- {{(Session::has('estado'))}} --}}
    @if (Session::get('estado') == 'ok')

        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Eliminado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
        </script>

    @endif
    @if (Session::get('estado') == 'error')

        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'No se puede borrar el tipo de documento.',
                showConfirmButton: false,
                timer: 1500
            })
        </script>

    @endif

    {{-- MENSAJES AL CREAR --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'El trámite ya existe.',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif
    @if (Session::get('estado') == 'registrado')
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Tipo de trámite añadido correctamente.',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    @endif

    <script>
        $(document).ready(function() {


            $(".tramite_confirmar").click(function() {
                var codigo = $(this).val();
                //alert($(this).val());
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                    back();
                })

            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".tramite_confirmar_ajax").click(function() {
                var codigo = $(this).val();
                // alert( $(this).val() );
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.tramites.aceptar_ajax') }}",
                    data: {
                        codigo: codigo
                    },
                    beforeSend: function() {
                        $("#estado").css('display', 'block').delay(50000);
                        $(this).html('Guardando datos...');

                        // $("#estado").css('display','none')
                    },
                    success: function(data) {
                        alert("Se ha realizado el POST con exito " + data);
                    }
                });
            });

            //scripts table
            $('#tipodocedientes').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                //"order": [
                //    [1, "asc"]
                //],

            });
        });
    </script>
@endpush
