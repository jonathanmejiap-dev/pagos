@extends('layouts.admin')
@push('styles')
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Texto único de procedimientos administrativos</h1>
        <a href="#crear" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#crear">
            <i class="fas fa-plus-square"></i> Añadir procedimiento</a>

    </div>



    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            {{-- <h3>Lista de trámites permitidos</h3> --}}
            <table id="tipodocedientes" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tupas as $tupa)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td>{{ $tupa->nombre }}</td>
                            <td class="font-weight-bold text-center text-white bg-success">S/. {{ $tupa->monto }}</td>
                            <td class="text-center">{!! $tupa->estado = 0 ? '<span class="badge badge-danger">No disponible</span>' : '<span class="badge badge-success">Activo</span>' !!}</td>

                            <td class="text-center">
                                <form method="POST" style="display:inline"
                                    action="{{ route('admin.tupas.destroy', $tupa) }}">
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
                        <th>Nombre</th>
                        <th>Monto</th>
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
    <div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear nuevo tipo de trámite</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.tupas.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre del tipo de trámite:</label>
                            <input type="text" 
                                    name="nombre" id="nombre" 
                                    class="form-control" 
                                    placeholder="Ingresar nombre"
                                    required>
                            {{-- <small id="nombre" class="form-text text-muted">.</small> --}}
                        </div>
                        <div class="form-group">
                            <label for="monto">Monto:</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">S/. </div>
                                </div>
                                <input type="number" 
                                    min="0" max="2000" step="0.1" 
                                    name="monto" id="monto" 
                                    class="form-control" 
                                    placeholder="200.00"
                                    required>
                            </div>
                            
                            {{-- <small id="nombre" class="form-text text-muted">.</small> --}}
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Crear</button>
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
            title: 'Procedimiento registrado correctamente.',
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
                "order": [[ 1, "asc" ]],

            });
        });
    </script>
@endpush
