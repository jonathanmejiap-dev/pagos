@extends('layouts.admin')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
@endpush
@section('content')

    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Página Principal</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>
        <div class="row">
            @php
                //contador
                $c_enviados = App\Pago::where('estado', '0')->count();
                $c_aceptados = App\Pago::where('estado', '1')->count();
                $c_rechazados = App\Pago::where('estado', '2')->count();
                $c_bajas = App\Pago::where('estado', '3')->count();
                
                $pagos = App\Pago::all();
                $s_enviados = 0;
                $s_aceptados = 0;
                $s_rechazados = 0;
                $s_bajas = 0;
                
                foreach ($pagos as $pago) {
                    switch ($pago->estado) {
                        case 0:
                            $s_enviados += $pago->monto;
                            break;
                        case 1:
                            $s_aceptados += $pago->monto;
                            break;
                        case 2:
                            $s_rechazados += $pago->monto;
                            break;
                        case 3:
                            $s_bajas += $pago->monto;
                            break;
                    }
                }
                
            @endphp

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="{{ route('admin.pagos.index') }}"
                                    class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pagos Enviados</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-thermometer-half"></i>
                                    {{ $c_enviados }} <br>
                                    <span class="text-danger">S/. {{ number_format($s_enviados, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill-alt  fa-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="{{ route('admin.pagos.index_confirmados') }}"
                                    class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pagos Confirmados</a>

                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-thermometer-half"></i>
                                    {{ $c_aceptados }}
                                    <br>
                                    <span class="text-danger">S/. {{ number_format($s_aceptados, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="{{ route('admin.pagos.index_rechazados') }}"
                                    class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Pagos Rechazados</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-thermometer-half"></i>
                                    {{ $c_rechazados }}
                                    <br>
                                    <span class="text-danger">S/. {{ number_format($s_rechazados, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-ban fa-2x text-gray-300"></i>
                                {{-- <i class="fas fa-ban"></i> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="{{ route('admin.pagos.index_bajas') }}"
                                    class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pagos dados de bajas</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <i class="fas fa-thermometer-half"></i>
                                    {{ $c_bajas }}
                                    <br>
                                    <span class="text-danger">S/. {{ number_format($s_bajas, 2) }}</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-minus-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>


        <div class="row">
            <!-- Area Chart -->
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Suma de montos procesados mensualmente</h6>
                        <div class="dropdown no-arrow">
                            {{-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a> --}}
                            {{-- <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div> --}}
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart" style="width:100% !important;height:100% !important;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> --}}

    <script src="{{ asset('js/Chart.min.js') }}"></script>

    <script>
        var pagos = [];
        var valores = [];
        var contador = 0;
        var mes = new Intl.DateTimeFormat('es-ES', {
            month: 'long'
        }).format(new Date());

        //valores usados
        var titulos = [];
        var datos = [];


        // var d = new Date(); 
        // var mes = d.getMonth()+1;


        $(document).ready(function() {
            //funcion ajax para contar los nuevos expedientes
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: "POST",
                url: "{{ route('admin.pago.graficos') }}",
                data: {
                    codigo: '1'
                },
                //correcto
                // success: function(data) {
                //     alert("Se ha realizado el POST con exito " + data);
                //     // $("#nuevos_tramites").text(data);
                // }
                //correcto
            }).done(function(data) {
                // alert("hola"+data);
                // console.log(data);
                var arreglo = JSON.parse(data);
                // for (x = 0; x < arreglo.length; x++) {
                //     pagos.push(arreglo[x].tupa_id);
                //     valores.push(arreglo[x].tupa_id);
                // }
                for (x = 0; x < arreglo.length; x++) {
                    contador++;
                    // console.log(arreglo[x].Total);
                    titulos.push(arreglo[x].Estado);
                    datos.push(arreglo[x].Total);
                }
                // console.log(arreglo);
                // console.log(arreglo[0])
                pagos.push(mes);
                valores.push(contador);
                generarGrafica();
            });


            //fun de ajax

            //inicio de chart.js



        });

        function generarGrafica() {
            var ctx = document.getElementById('myAreaChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Enviados', 'Confirmados', 'Rechazados', 'Bajas'],
                    datasets: [{
                        label: 'Suma de montos S/. ',
                        data: datos,
                        backgroundColor: [
                            'rgba(52, 152, 219, 0.2)',
                            'rgba(40, 180, 99, 0.2)',
                            'rgba(231, 76, 60, 0.2)',
                            'rgba(244, 208, 63, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(52, 152, 219, 0.2)',
                            'rgba(40, 180, 99, 0.2)',
                            'rgba(231, 76, 60, 1)',
                            'rgba(244, 208, 63, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,

                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Chart Title'
                        }
                    },

                }
            });

        }
    </script>
@endpush
