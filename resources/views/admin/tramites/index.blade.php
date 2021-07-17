@extends('layouts.admin')
@push('styles')


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Trámites</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}

    </div>
    <div class="row">

        <div class="col-md-12 pb-4 bg-white">
            <div class="card">
                <div class="card-body">

                    {{-- ******************CONTENIDO DEL CARD**************** --}}
                    <div class="row">
                        <div class="col-md-12">
                            <form id="form_tipo" action=" {{ route('admin.tramites') }}" method="GET">
                                <div class="form-row align-items-center">
                                    <div class="col-auto">
                                        <label for="exampleFormControlSelect1"><b>Trámites documentarios: </b></label>
                                    </div>
                                    <div class="col-auto">
                                        <select class="form-control" name="tipo" id="tipo">
                                            <option value="1" {{ Session::get('codigo') == '1' ? 'selected' : null }}>
                                                Enviados</option>
                                            <option value="2" {{ Session::get('codigo') == '2' ? 'selected' : null }}>
                                                Aceptados</option>
                                            <option value="3" {{ Session::get('codigo') == '3' ? 'selected' : null }}>
                                                Rechazados</option>
                                            <option value="4" {{ Session::get('codigo') == '4' ? 'selected' : null }}>
                                                Derivados</option>
                                            <option value="5" {{ Session::get('codigo') == '5' ? 'selected' : null }}>
                                                Finalizados</option>
                                        </select>
                                    </div>

                                    <div class="col-auto">
                                        <button class="btn btn-primary ">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    {{-- ******************CONTENIDO TABLA**************** --}}
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <h3>Resultados de búsqueda</h3>
                            <table id="expedientes" class="table table-striped table-bordered dt-responsive nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Asunto</th>
                                        <th>Inicio</th>

                                        <th>Area</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{dd($expedientes)}} --}}
                                    @foreach ($expedientes as $exp)

                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td class="font-weight-bold">{{ $exp->id }}</td>

                                            <td>
                                                <b class="text-primary"> <i class="fas fa-file-alt"></i>
                                                    {{ $exp->tipo_documento->nombre }}</b><br> <b
                                                    class="font-italic">"{{ $exp->asunto }}"</b>
                                                <button type="button" value="{{ $exp->id }}"
                                                    class="btn btn-primary btn-sm ver_detalle float-right"
                                                    data-toggle="modal" data-target="#detallesModal">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">
                                                
                                                @php

                                                    $fecha = ($exp->created_at);
                                                    $fecha_formateada = $fecha->format('d-m-Y H:i:s');
                                                    echo($fecha_formateada)."<br>";
                                                    
                                                    Carbon\Carbon::setLocale('es');
                                                    $fecha = Carbon\Carbon::parse($exp->updated_at);
                                                    echo '<i class="fas fa-calendar-check text-danger"></i> <span class="small font-weight-bold">'.$fecha->diffForHumans()."</span>";
                                                    
                                                @endphp
                                            </td>

                                            <td class="text-center">
                                                    @php
                                                        if (count($exp->seguimientos) != 0) {
                                                            foreach ($exp->seguimientos as $reg) {
                                                                $area_final = $reg->area->nombre;
                                                            }
                                                            echo '<span class="badge badge-success">'.
                                                                $area_final.
                                                                '</span>';
                                                        }else{
                                                            echo '<span class="badge badge-secondary">'.
                                                                '<i class="fas fa-minus-circle"></i>'.
                                                                '</span>';
                                                        }
                                                        
                                                    @endphp
                                                </td>

                                            <td class="text-center">
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
                                            <td>

                                                @if ($exp->estado == 1)
                                                    @can('haveaccess','secretaria.academica')
                                                    <a href="{{ route('admin.tramite.aceptar', $exp) }}"
                                                        class="btn btn-success btn-sm">
                                                        <small> <i class="fas fa-check-circle"></i> Aceptar</small>
                                                    </a>
                                                   


                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        data-target="#rechazarModal{{ $exp->id }}">
                                                        <small> <i class="fas fa-minus-circle"></i> Rechazar</small>
                                                    </button>
                                                    @endcan

                                                    <div class="modal fade" id="rechazarModal{{ $exp->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Confirmar
                                                                        rechazo</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('admin.tramite.rechazar', $exp) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label for="mensaje">Mensaje de
                                                                                atención:</label>
                                                                            <textarea class="form-control" id="mensaje"
                                                                                name="mensaje" rows="3" required></textarea>
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Confirmar</button>

                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Cerrar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($exp->estado == 4)
                                                    {{-- Modal DETALLES SEGUIMIENTO --}}
                                                    <div class="modal fade" id="detallesModal{{ $exp->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Seguimiento del trámite:
                                                                        {{ $exp->id }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="bg-white rounded box-shadow">
                                                                                <h6
                                                                                    class="border-bottom border-gray pb-2 mb-0">
                                                                                    Inicio de proceso
                                                                                </h6>
                                                                                @foreach ($exp->seguimientos as $seg)
                                                                                    <div class="media text-muted pt-3">
                                                                                        <div class="mr-2 rounded"
                                                                                            style="width: 72px; height: 72px;">

                                                                                            @if ($seg->movimiento_id == 1)
                                                                                                <i
                                                                                                    class="fas fa-paper-plane fa-3x"></i>
                                                                                            @endif
                                                                                            @if ($seg->movimiento_id == 2)
                                                                                                <i
                                                                                                    class="fas fa-vote-yea text-primary fa-3x"></i>
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
                                                                                                <strong
                                                                                                    class="text-gray-dark">
                                                                                                    @if ($seg->movimiento_id == 1)
                                                                                                        <span
                                                                                                            class="badge badge-secondary p4 m4">Enviado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 2)
                                                                                                        <span
                                                                                                            class="badge badge-primary">Aceptado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 3)
                                                                                                        <span
                                                                                                            class="badge badge-danger">Rechazado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 4)
                                                                                                        <span
                                                                                                            class="badge badge-warning">Derivado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 5)
                                                                                                        <span
                                                                                                            class="badge badge-success">Finalizado</span>
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
                                                                                            <p
                                                                                                class="text-justify text-wrap">
                                                                                                <b>{{ $seg->area->nombre }}</b>

                                                                                                <br>
                                                                                                {!! $seg->acciones !!}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <small class="d-block text-right mt-3">
                                                                                    <a href="{{ url('/') }}">Realizar
                                                                                        otro trámite</a>
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
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        title=" ver seguimiento" data-toggle="modal"
                                                        data-target="#detallesModal{{ $exp->id }}">
                                                        <i class="fas fa-eye"></i> Seguimiento
                                                    </button>

                                                    {{-- *********************FIN VER DETALLES SEGUIMIENTO******************* --}}
                                                @endif

                                                @if ($exp->estado == 2 || $exp->estado == 4)
                                                    <form action="{{ route('admin.seguimiento.store', $exp) }}"
                                                        method="POST">
                                                        @csrf
                                                        {{-- *****************MODAL SEGUIMIENTOS******************* --}}
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="seguimientoModal{{ $exp->id }}"
                                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog " role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            <b>Acciones para derivar el documento:
                                                                                {{ $exp->id }}</b>
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="bg-light">


                                                                                    <b>Área de procedencia: </b>
                                                                                    <span class="btn btn-success btn-sm">
                                                                                        @php
                                                                                            foreach ($exp->seguimientos as $reg) {
                                                                                                $area_final = $reg->area->nombre;
                                                                                            }
                                                                                            echo $area_final;
                                                                                        @endphp
                                                                                    </span>
                                                                                </div>
                                                                                <hr>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6 mb-6">
                                                                                <label for="country"
                                                                                    class="font-weight-bold">Acción a
                                                                                    realizar:</label>
                                                                                <select class="custom-select d-block w-100"
                                                                                    id="movimiento" name="movimiento"
                                                                                    required="required">
                                                                                    <option value="Seleccionar">
                                                                                        SELECCIONAR...</option>
                                                                                    @foreach ($movimientos as $mov)
                                                                                        <option
                                                                                            value="{{ $mov->id }}">
                                                                                            {{ $mov->nombre }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <div class="invalid-feedback">
                                                                                    Please select a valid country.
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 mb-6">
                                                                                <label for="area"
                                                                                    class="font-weight-bold">Área</label>
                                                                                <select class="custom-select d-block w-100"
                                                                                    id="state" name="area"
                                                                                    required="required">
                                                                                    <option value="">SELECCIONAR...</option>
                                                                                    @foreach ($areas as $area)
                                                                                        <option
                                                                                            value="{{ $area->id }}">
                                                                                            {{ $area->nombre }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <div class="invalid-feedback">
                                                                                    Please provide a valid state.
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        {{-- <div class="row">
                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="firstName">First name</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="firstName" placeholder="" value=""
                                                                                    required="">
                                                                                <div class="invalid-feedback">
                                                                                    Valid first name is required.
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6 mb-3">
                                                                                <label for="lastName">Last name</label>
                                                                                <input type="text" class="form-control"
                                                                                    id="lastName" placeholder="" value=""
                                                                                    required="">
                                                                                <div class="invalid-feedback">
                                                                                    Valid last name is required.
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <div class="mb-3">
                                                                            <label for="mensaje"
                                                                                class="font-weight-bold">Mensaje para su
                                                                                atención:</label>
                                                                            <textarea class="form-control" name="mensaje"
                                                                                id="mensaje" rows="3" required></textarea>
                                                                            <div class="invalid-feedback">
                                                                                Please enter your shipping address.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Cerrar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Guardar cambios</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                        title="Derivar documento"
                                                        data-target="#seguimientoModal{{ $exp->id }}">
                                                        <i class="fas fa-share-square"></i> Derivar
                                                    </button>
                                                @endif



                                                @if ($exp->estado == 5 )
                                                    {{-- Modal DETALLES SEGUIMIENTO --}}
                                                    <div class="modal fade" id="detallesModal{{ $exp->id }}"
                                                        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                                        Seguimiento del trámite:
                                                                        {{ $exp->id }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"
                                                                        aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="bg-white rounded box-shadow">
                                                                                <h6
                                                                                    class="border-bottom border-gray pb-2 mb-0">
                                                                                    Inicio de proceso
                                                                                </h6>
                                                                                @foreach ($exp->seguimientos as $seg)
                                                                                    <div class="media text-muted pt-3">
                                                                                        <div class="mr-2 rounded"
                                                                                            style="width: 72px; height: 72px;">

                                                                                            @if ($seg->movimiento_id == 1)
                                                                                                <i
                                                                                                    class="fas fa-paper-plane fa-3x"></i>
                                                                                            @endif
                                                                                            @if ($seg->movimiento_id == 2)
                                                                                                <i
                                                                                                    class="fas fa-vote-yea text-primary fa-3x"></i>
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
                                                                                                <strong
                                                                                                    class="text-gray-dark">
                                                                                                    @if ($seg->movimiento_id == 1)
                                                                                                        <span
                                                                                                            class="badge badge-secondary p4 m4">Enviado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 2)
                                                                                                        <span
                                                                                                            class="badge badge-primary">Aceptado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 3)
                                                                                                        <span
                                                                                                            class="badge badge-danger">Rechazado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 4)
                                                                                                        <span
                                                                                                            class="badge badge-warning">Derivado</span>
                                                                                                    @endif
                                                                                                    @if ($seg->movimiento_id == 5)
                                                                                                        <span
                                                                                                            class="badge badge-success">Finalizado</span>
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
                                                                                            <p
                                                                                                class="text-justify text-wrap">
                                                                                                <b>{{ $seg->area->nombre }}</b>

                                                                                                <br>
                                                                                                {!! $seg->acciones !!}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <small class="d-block text-right mt-3">
                                                                                    <a href="{{ url('/') }}">Realizar
                                                                                        otro trámite</a>
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
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        title=" ver seguimiento" data-toggle="modal"
                                                        data-target="#detallesModal{{ $exp->id }}">
                                                        <i class="fas fa-eye"></i> Seguimiento
                                                    </button>
                                                    <br>

                                                    {{-- *********************FIN VER DETALLES SEGUIMIENTO******************* --}}
                                                    
                                                        Documento finalizado
                                                    
                                                @endif


                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Asunto</th>
                                        <th>Inicio</th>

                                        <th>Area</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    <!-- Content Row -->
                </div>

            </div>


        </div>
    </div>


    {{-- *****************MODAL PARA VER DETALLES******************* --}}
    <!-- Modal detalles-->
    <div class="modal fade" id="detallesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Remitente y documento: #<span
                            id="txt_codigo"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header">
                                    <b>Tipo documento: <span id="txt_tipodocumento"></span></b>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <b class="">N° folios: <span id="txt_folios"></span></b>
                                            <h3 class="mb-0">
                                                <b class="text-dark">Asunto: <span id="txt_asunto"></span></b>
                                            </h3>
                                            <div class="mb-1 text-muted"> <b class="text-dark">Fecha de envio:</b> <span
                                                    id="txt_fecha"></span></div>
                                        </div>
                                        <div class="col-md-4">
                                            <strong class="d-inline-block mb-2 text-success">DNI: <span
                                                    id="txt_dni"></span></strong>
                                            <h3 class="mb-0">
                                                <span class="text-dark" id="txt_nombres"></span>
                                            </h3>
                                        </div>
                                    </div>



                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card mt-4">
                                <div class="card-header">
                                    <b>Documento:</b>
                                </div>
                                <div class="card-body d-flex flex-column align-items-start">
                                    <div class="row">
                                        <div class="col-md-12" id="archivo_ver"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
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

    @if (Session::get('estado') == 'aceptado')
        <script>
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Trámite aceptado correctamente.',
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
                title: 'Trámite rechazado correctamente.',
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
            //acción para crear via ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".ver_detalle").click(function() {
                var codigo = $(this).val();
                // alert($(this).val());
                $.ajax({
                    type: "post",
                    url: "{{ route('admin.tramites.ver_detalles') }}",
                    data: {
                        codigo: codigo
                    },
                    success: function(data) {
                        // alert("Se ha realizado el POST con exito " + data);
                        console.log(data);
                        $('#txt_codigo').text(data['id']);
                        // $('#txt_tipodocumento').text(data['tipo_documento_id']);
                        $('#txt_folios').text(data['num_folios']);
                        $('#txt_tipodocumento').text(data['nombre_tipo']);
                        $('#txt_asunto').text(data['asunto']);

                        if (data['url'] != null) {
                            //$('#txt_url').text(data['url']);
                            var link_archivo = data['url'];
                            $('#archivo_ver').html('<a href="' + link_archivo +
                                '" target="blank_"><i class="fab fa-edge" aria-hidden="true"></i> Ver archivo compartido</a>'
                            );
                        } else {
                            if (data['archivo'] != null) {
                                var link_archivo2 = data['archivo'];
                                $('#archivo_ver').html('<a href="../../storage/app/public/' +
                                    link_archivo2 +
                                    '" target="blank_"> <i class="fas fa-download"></i> Descargar el archivo</a>'
                                );

                            }
                        }

                        $('#txt_dni').text(data['navegante_id']);
                        $('#txt_nombres').text(data['nombre_navegante']);

                        var fecha = new Date(data['created_at']);
                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        };
                        $('#txt_fecha').text(fecha.toLocaleDateString("es-ES", options));

                        // console.log(
                        // fecha.toLocaleDateString("es-ES", options)
                        // );

                        // console.log(data);
                    }
                });
            });

            $("#tipo").change(function() {
                $("#form_tipo").submit();
            });

            //scripts table
            $('#expedientes').DataTable({
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
                "order": [
                    [4, "desc"]
                ],

            });
        });
    </script>
@endpush
