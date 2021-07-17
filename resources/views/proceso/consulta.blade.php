@extends('plantilla')
@section('titulo', 'MESA DE PARTES')

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    @endpush

@section('contenido')
    <div class="">
        @foreach ($navegante as $nav)
            <div class="row">
                <div class="col-md 12 pb-2 mb-4">
                    <div class="card">
                        <h5 class="card-header bg-primary text-white"><b>Usuario activo</b></h5>
                        <div class="card-body">
                            <h5 class="card-title"><b>Nombres y apellidos: {{ $nav->nombres }}</b></h5>

                            <p class="card-text">

                                <a href="{{ route('mesa.home') }}" class="btn btn-primary float-right"><i
                                        class="far fa-arrow-alt-circle-left"></i> Volver al inicio</i></a>
                                <b>Email:</b> {{ $nav->email }}<br>

                                <b>Telefono:</b> {{ $nav->telefono }} <br>
                                <b>Dirección:</b> {{ $nav->direccion }}

                            </p>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <h2>Resultados de búsqueda</h2>
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expedientes as $exp)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td><b> {{ $exp->id }}</b></td>

                        <td>
                            <b class="text-primary">
                                <i class="fas fa-file-alt"></i> {{ $exp->tipo_documento->nombre }}
                            </b>
                                <br><b class="font-italic">"{{ $exp->asunto }}"</b>
                        </td>
                        <td> 
                            <i class="fas fa-paper-plane"></i> {{ Carbon\Carbon::parse($exp->created_at)->format('d/m/Y') }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($exp->updated_at)->format('d/m/Y') }}
                        </td>
                        <td>
                            @php
                                
                                switch ($exp->estado) {
                                    case 1:
                                        echo "<span class='badge badge-secondary'>Enviado</span>";
                                        break;
                                    case 2:
                                        echo "<span class='badge badge-primary'>Aceptado</span>";
                                        break;
                                    case 3:
                                        echo "<span class='badge badge-danger'>Rechazado</span>";
                                        break;
                                    case 4:
                                        echo "<span class='badge badge-warning'>Derivado</span>";
                                        break;
                                    case 5:
                                        echo "<span class='badge badge-success'>Finalizado</span>";
                                        break;
                                }
                            @endphp
                        </td>
                        <td title="Ver detalles">
                            {{-- Modal SEGUIMIENTO --}}
                            <div class="modal fade" id="seguimientoModal{{ $exp->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Seguimiento del trámite:
                                                {{ $exp->id }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="bg-white rounded box-shadow">
                                                        <h6 class="border-bottom border-gray pb-2 mb-0">Inicio de proceso
                                                        </h6>
                                                        @foreach ($exp->seguimientos as $seg)
                                                            <div class="media text-muted pt-3">
                                                                <div class="mr-2 rounded"
                                                                    style="width: 72px; height: 72px;">

                                                                    @if ($seg->movimiento_id == 1)
                                                                        <i class="fas fa-paper-plane fa-3x"></i>
                                                                    @endif
                                                                    @if ($seg->movimiento_id == 2)
                                                                        <i class="fas fa-vote-yea text-primary fa-3x"></i>
                                                                    @endif
                                                                    @if ($seg->movimiento_id == 3)
                                                                        <i
                                                                            class="fas fa-minus-circle text-danger fa-3x"></i>
                                                                    @endif
                                                                    @if ($seg->movimiento_id == 4)
                                                                        <i
                                                                            class="fas fa-project-diagram text-warning fa-3x"></i>
                                                                    @endif
                                                                    @if ($seg->movimiento_id == 5)
                                                                        <i
                                                                            class="fas fa-check-circle text-success fa-3x"></i>
                                                                    @endif


                                                                </div>


                                                                <div
                                                                    class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center w-100">
                                                                        <strong class="text-gray-dark">
                                                                            @if ($seg->movimiento_id == 1)
                                                                             <span class="badge badge-secondary p4 m4">Enviado</span>
                                                                            @endif
                                                                            @if ($seg->movimiento_id == 2)
                                                                            <span class="badge badge-primary">Aceptado</span>
                                                                            @endif
                                                                            @if ($seg->movimiento_id == 3)
                                                                            <span class="badge badge-danger">Rechazado</span>
                                                                            @endif
                                                                            @if ($seg->movimiento_id == 4)
                                                                            <span class="badge badge-warning">Derivado</span>
                                                                            @endif
                                                                            @if ($seg->movimiento_id == 5)
                                                                            <span class="badge badge-success">Finalizado</span>
                                                                            @endif
                                                                            @php
                                                                                
                                                                                Carbon\Carbon::setLocale('es');
                                                                                echo Carbon\Carbon::parse($seg->updated_at)->format('d-m-Y');
                                                                                
                                                                            @endphp
                                                                        </strong>
                                                                        <span class="text-primary">
                                                                            @php
                                                                                $fecha = Carbon\Carbon::parse($seg->updated_at);
                                                                                echo $fecha->diffForHumans(); //esto se mostrará en español
                                                                                
                                                                            @endphp
                                                                        </span>
                                                                    </div>
                                                                    <p class="text-justify text-wrap">
                                                                        <b>{{$seg->area->nombre}}</b>
                                                                       
                                                                        <br>
                                                                        {!! $seg->acciones !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <small class="d-block text-right mt-3">
                                                            <a href="{{url('/')}}">Realizar otro trámite</a>
                                                        </small>
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
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#seguimientoModal{{ $exp->id }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            {{-- *********************FIN VER SEGUIMIENTO******************* --}}
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th>Orden</th>
                    <th>Código</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Ver</th>
                </tr>
            </tfoot>
        </table>
    </div>



@endsection

@push('scripts')
    <script type="text/javascript" src="js/app.js"></script>
    {{-- <script  src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}


    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
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
