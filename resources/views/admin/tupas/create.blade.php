@extends('layouts.admin')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Crear tipo de trámite</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Añadir tipo trámite</a> --}}

    </div>



    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            {{-- <h3>Lista de trámites permitidos</h3> --}}
            <div class="card">
                <div class="card-header">
                    Datos
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tipodocumento.create') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre del tipo de trámite:</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingresar nombre">
                            {{-- <small id="nombre" class="form-text text-muted">.</small> --}}
                        </div>
                        {{-- <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                          </div>
                          <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                          </div> --}}
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

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

            });
        });
    </script>
@endpush
