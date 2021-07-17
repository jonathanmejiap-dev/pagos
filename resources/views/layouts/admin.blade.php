<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta property='og:locale' content='es_ES' />
    <meta property='og:type' content='website' />
    <meta property='og:title'
        content="@yield('titulo', 'CONTROL DE PAGOS - IESTP Señor de la Divina Misericordia - Ocros')" />
    <meta property='og:site_name' content='IESTP Señor de la Divina Misericordia - Ocros' />
    <meta property='og:url' content="@yield('url_redes','')" />
    <meta property='og:site_name' content='@yield('
        titulo', 'CONTROL DE PAGOS - IESTP Señor de la Divina Misericordia - Ocros' )' />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo', 'CONTROL DE PAGOS - IESTP Señor de la Divina Misericordia - Ocros')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d132af9381.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    @stack('styles')

</head>

<body onload="deshabilitaRetroceso()">
    <div id="">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    IESTP Señor de la divina Misericordia
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">


                    <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <div class="nav-link text-dark">
                                @php
                                    setlocale(LC_ALL, 'es_ES');
                                    $date = Carbon\Carbon::now();
                                    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                    $fecha = Carbon\Carbon::parse($date);
                                    $mes = $meses[$fecha->format('n') - 1];
                                    echo $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y') . ' |  ';
                                @endphp

                                <span id="reloj" class="reloj" style="color: dark;  padding-left:10px">
                                </span>
                            </div>
                        </li>
                        <li class="nav-item"><a href="https://isdm.edu.pe" target="_blank" class="nav-link text-primary"><i
                            <i class="fas fa-university pl-4"></i> Sitio web institucional</a></li>
                        <li>
                            <a href="https://www.bn.com.pe/banca-internet/banca-internet.asp" target="_blank" class="nav-link text-danger"> 
                                <i class="fas fa-money-check pl-4"></i> Banca por internet BN</a>
                        </li>
                        {{-- @can('haveaccess', 'role.index')
                            <li class="nav-item"><a href="{{ route('role.index') }}" class="nav-link">Roles</a></li>
                        @endcan
                        @can('haveaccess', 'user.index')
                            <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link">Usuarios</a></li>
                        @endcan --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                {{-- <a class="nav-link" href="{{ route('login') }}">{{ __('Ingresar') }}</a> --}}
                                <a class="nav-link" href="{{ route('mesa.home') }}">{{ __('Volver') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Registrar') }}</a> --}}
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                        {{-- {{ __('Logout') }} --}}
                                        {{-- <i class="fas fa-file-import"></i> --}}
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="">
            <div id="wrapper">

                @include('layouts.admin_sidebar')

                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content ">



                        <!-- Begin Page Content -->
                        <div class="container-fluid pt-3">

                            @yield('content')


                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    @include('layouts.admin_footer')
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>

        </main>
    </div>
</body>
<!-- Scripts -->
<style>

</style>
<script src="{{ asset('js/app.js') }}"></script>

<script>
    function actual() {
        fecha = new Date(); //Actualizar fecha.
        hora = fecha.getHours(); //hora actual
        minuto = fecha.getMinutes(); //minuto actual
        segundo = fecha.getSeconds(); //segundo actual
        if (hora < 10) { //dos cifras para la hora
            hora = "0" + hora;
        }
        if (minuto < 10) { //dos cifras para el minuto
            minuto = "0" + minuto;
        }
        if (segundo < 10) { //dos cifras para el segundo
            segundo = "0" + segundo;
        }
        //ver en el recuadro del reloj:
        mireloj = hora + " : " + minuto + " : " + segundo;
        return mireloj;
    }

    function actualizar() { //función del temporizador
        mihora = actual(); //recoger hora actual
        mireloj = document.getElementById("reloj"); //buscar elemento reloj
        mireloj.innerHTML = mihora; //incluir hora en elemento
    }
    actualizar();
    setInterval(actualizar, 1000); //iniciar temporizador


    //evitar hacer back
    function deshabilitaRetroceso() {
        window.location.hash="no-back-button";
                window.location.hash="Again-No-back-button"; //chrome
                window.onhashchange=function(){window.location.hash="";}
    }
</script>
@stack('scripts')

</html>
