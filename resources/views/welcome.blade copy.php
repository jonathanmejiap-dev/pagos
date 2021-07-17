<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/d132af9381.js" crossorigin="anonymous"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
              
            }
            

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Inicio</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}">Registrar</a>
                        @endif --}}
                    @endauth
                </div>
            @endif

            <div class="content">
                <img src="{{asset("img/logo_isdm.png")}}" alt="logo">
                <div class="title m-b-md">
                    MESA DE PARTES
                </div>

                <div class="row">
                    <div class="col-md-12 text-left" >
                        <form action="{{route('proceso.index')}}" method="POST">
                            @csrf
                           
                            <div class="form-group">
                                <label class="sr-only" for="inlineFormInputGroup">Elige una opción</label>
                                <div class="input-group mb-2">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-crosshairs"></i></div>
                                  </div>
                              <select class="form-control" name="opcion" required="required" id="exampleFormControlSelect1">
                                <option value="">Elige una opción</option>
                                <option value="consultar">Consultar</option>
                                <option value="tramitar">Realizar trámite</option>
                                
                              </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="sr-only" for="inlineFormInputGroup">DNI</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" name="dni" minlength="8" class="form-control" required id="inlineFormInputGroup" placeholder="DNI">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 text-center py-4 pb-4 mb-4">
                                    <button type="submit" class="btn btn-primary font-weight-bold">Procesar</button>
                                    {{-- <button type="button" class="btn btn-light">Light</button> --}}
                                </div>
                            </div>
                           
                          </form>
                    </div>
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://vapor.laravel.com">Vapor</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="js/app.js"></script>
    
    @if(Session::has('error'))  
            <script type="text/javascript">
                function actualizar(){location.reload(true);}
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

    @if(Session::has('estado')=="registro-ok")  
            <script type="text/javascript">
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Trámite registrado correctamente.',
                showConfirmButton: true,
                timer: 2500
                })
                
            </script>
    @endif
    

</html>
