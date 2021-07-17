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

        
        <h1 class="h3 mb-0 text-primary font-weight-bold"><i class="fas fa-share-square"></i> Pagos enviados <br></h1>
        {{-- CONTADORES --}}
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Monto Enviado: </div>
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
                            Total enviados: </div>
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
        {{-- FIN CONTADORES --}}
        <div>
            <a href="{{ route('admin.pagos.index_confirmados') }}" class="btn btn-sm btn-success shadow-sm">
                <i class="fas fa-check-circle text-white-50"></i> Pagos confirmados</a>
                <br>
                <a href="{{ route('home') }}" class="btn btn-sm btn-light shadow-sm ">
                    <i class="fas fa-check-circle text-white-50"></i> Página principal <i class="fas fa-house-user"></i>
                </a>
        </div>
        
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
                        <th>Monto Pagado</th>
                        <th>Estado</th>
                        <th>Enviado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pagos as $pago)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="font-weight-bold"><i class="fas fa-key"></i> 
                                {{ $pago->num_op }}
                            </td>
                            <td>
                                <b class="text-primary">Procedimiento:</b> <b>{{ $pago->tupa->nombre }}</b>
                                <br>
                                <i class="fas fa-user"></i> {{$pago->navegante->nombres}} 
                                <br>
                                <b class="text-danger">S/. {{ $pago->tupa->monto }}</b>
                                {{-- Descargar archivo --}}
                                <a href="{{asset($pago->archivo) }}" class="btn btn-primary float-right btn-sm" target="_blank" title="Ver archivo adjunto"> 
                                    <i class="fas fa-file-download"></i>
                                </a>
                                {{-- Ver detalles --}}
                                <button type="button" class="btn btn-primary float-right btn-sm  mx-2" title="ver detalles" data-toggle="modal"
                                    data-target="#detalleUsuarioModal{{ $pago->id }}">
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
                                                                    @if ($pago->navegante->estado == '1')
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
                                                        <h5 class="card-header bg-success text-white"># Operación: {{ $pago->num_op }}</h5>
                                                        <div class="card-body">
                                                            <h5 class="card-title"><b>Procedimiento:</b>  {{ $pago->tupa->nombre }}</h5>
                                                            <h5 class="card-title"><b>Monto depositado: </b>S/. {{ number_format($pago->monto, 2) }}</h5>
                                                            <a href="{{asset($pago->archivo) }}" class="btn btn-primary btn-block" target="_blank"> 
                                                                <i class="fas fa-file-download"></i> Archivo adjunto
                                                            </a>
                                                            
                                                            <small class="text-muted">Enviado: {{$pago->created_at}}</small>
                                                            <div class="alert alert-light text-center" role="alert">
                                                                "{{$pago->mensaje}}"
                                                              </div>

                                                        </div>
                                                    </div>
                                                



                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            <td style="vertical-align:middle;" class="bg-danger text-white text-center font-weight-bold h-100">
                                <span class="align-middle">
                                    <i class="fas fa-money-bill-alt"></i> S/. {{ $pago->monto }}
                                </span>
                            </td>
                            <td style="vertical-align:middle;" class="text-center"><span class="badge badge-danger"><i class="fas fa-eye"></i> <br>Enviado
                                    para <br>revisión</span>
                                    <br>
                                    <small class="text-center font-weight-bold">{{$pago->updated_at}}</small>   
                                </td>

                            <td>
                                {{-- CONFIRMAR PAGO --}}
                                <a href="{{ route('admin.pago.confirmar', $pago) }}" class="btn btn-success btn-sm">
                                    <small> <i class="fas fa-check-circle"></i> Confirmar</small>
                                </a>

                                {{-- RECHAZAR PAGO --}}
                                <button class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#rechazarModal{{ $pago->id }}">
                                    <small> <i class="fas fa-minus-circle"></i> Rechazar</small>
                                </button>

                                <div class="modal fade" id="rechazarModal{{ $pago->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Confirmar
                                                    rechazo</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.pago.rechazar', $pago) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="mensaje">Mensaje de
                                                            atención:</label>
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

                                {{-- ELIMINAR PAGO --}}
                                <form method="POST" style="display:inline"
                                    action="{{ route('admin.pago.destroy', $pago) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger"
                                        onclick="return confirm('Estas seguro que deseas eliminar la publicación')">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>

                            </td>



                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Concepto</th>
                        <th># Operación</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Enviado</th>
                    </tr>
                </tfoot>
            </table>

        </div>



    </div>

    <!-- Content Row -->


@endsection

@push('scripts')
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    {{-- *************VALIDACIONES************* --}}

    {{-- CONFIRMADO --}}
    {{-- {{(Session::has('estado'))}} --}}
    {{ Session::has('estado') }}
    {{ Session::get('estado') }}
    @if (Session::get('estado') == 'aceptado')
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Pago confirmado',
                showConfirmButton: false,
                timer: 2500
            })
        </script>

    @endif
    @if (Session::get('estado') == 'rechazado')

        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Pago rechazado correctamente',
                showConfirmButton: false,
                timer: 2500
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
