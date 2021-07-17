<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta property='og:locale' content='es_ES' />
    <meta property='og:type' content='website' />
    <meta property='og:title'
        content="@yield('titulo', 'CONTROL DE PAGOS - IESTP Señor de la Divina Misericordia - Ocros')" />
        <meta property='og:site_name' content='IESTP Señor de la Divina Misericordia - Ocros'/>
    <meta property='og:url' content="@yield('url_redes','')"/>
	<meta property='og:site_name' content='@yield('titulo', 'CONTROL DE PAGOS - IESTP Señor de la Divina Misericordia - Ocros')'/>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo', 'CONTROL DE PAGOS - IESTP Señor de la Divina Misericordia - Ocros')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d132af9381.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{asset('css/plantilla.css')}}">
    <!-- Styles -->
    <style>
        

    </style>

    @stack('styles')

</head>

<body>
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
            <a href="{{ url('/') }}"
                class="my-0 mr-md-auto font-weight-normal text-center font-weight-bold" >
                <i class="fas fa-cash-register"></i> CONTROL DE PAGOS <br>IESTP Señor de la Divina Misericordia</a>
            
            <nav class="my-2 my-md-0 mr-md-3">
              <a href="https://isdm.edu.pe"
                    class="p-2 text-dark" > 
                    <img src="{{asset("img/logo_isdm.png")}}" width="30" alt="logo">
                    Sitio Oficial
                </a>
              {{-- <a class="p-2 text-dark" href="#">Enterprise</a>
              <a class="p-2 text-dark" href="#">Support</a>
              <a class="p-2 text-dark" href="#">Pricing</a> --}}
            </nav>
            @if (Route::has('login'))
                   
                    @auth
                        <a href="{{ url('/admin/home') }}" 
                            class="btn btn-outline-primary">
                            Volver a la Administración
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                            class="btn btn-outline-primary">
                               Iniciar sesión
                        </a>
    
                        {{-- @if (Route::has('register'))
                                <a href="{{ route('register') }}">Registrar</a>
                            @endif --}}
                    @endauth
                    
                @endif
            {{-- <a class="btn btn-outline-primary" href="#">Sign up</a> --}}
          </div>
        <div class="container">
            {{-- <nav>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
        
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @can('haveaccess','role.index')
                        <li class="nav-item"><a href="{{route('role.index')}}" class="nav-link">Roles</a></li>
                        @endcan
                        @can('haveaccess','user.index')
                        <li class="nav-item"><a href="{{route('user.index')}}" class="nav-link">Usuarios</a></li>
                        @endcan
                    </ul>
                </div>
            </nav> --}}
            
        
        
                    @yield('contenido')
        
               
        </div>
    </div>

    <footer class="text-center mt-auto">
        <div class="inner">
            <hr>
          <p>
              <a href="https://isdm.edu.pe">IESTP Señor de la Divina Misericordia</a> -  {{date('Y')}}<br> 
              <small>Desarrollado por: <a href="https://getbootstrap.com/">Pan de Dios</a></small>
            </p> 
         
        </div>
      </footer>
</body>
<script type="text/javascript" src="{{asset("js/app.js")}}"></script>

@stack('scripts')

</html>
