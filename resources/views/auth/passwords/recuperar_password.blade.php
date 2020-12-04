<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.png"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>@yield('title', config('app.name', 'Login'))</title> --}}
    <title>Tu Vidriera en Internet</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

</head>
<body>
    <div class="ancho-100 flex flex-content-center" id="app">
        <video class="video_fondo" src="{{ Storage::url('login/video05.mp4') }}" autoplay loop muted></video>
        <div style="min-height: 100%;
            min-width: 100%; background: var(--main-ppal-color);opacity: .5; position: fixed; z-index: -1;">
        </div>
        <div class="ancho-90 ancho-m-50 ancho-l-40 ancho-lg-35" style="margin-top: 50px;">
            <form class="form" action="{{ route('recuperar_password_enviar_mail') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-head p-20">
                    <div class="ancho-100 flex flex-item-center flex-content-center">
                        {{-- <div class="form-titulo  fz-15">
                            Vidriera Online
                        </div> --}}
                        <div class=" flex flex-content-center flex-item-center m-r-10">
                            <img style="width: 50px;" src="/logo.png" alt="">
                        </div>
                        <div class="form-titulo ">
                            <div class="fz-20 txt-blanco">Vidriera Online</div>
                            <div class=""><i class="fz-15 txt-blanco">Tus Productos En Internet</i></div>
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="form-linea flex flex-content-center">
                        <div class="form-columna">
                            <div class="ancho-100 flex flex-item-center">
                                <div class="flex flex-content-center flex-item-center">
                                    <img style="width: 50px;" src="/images/reset_password.png" alt="">
                                </div>
                                <div class="form-titulo fz-20 m-l-15">
                                    Recuperar Contraseña
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-linea flex flex-content-center">
                        <div class="form-columna">
                            <div class="ancho-100 flex flex-item-center">
                                <div class="form-titulo ">
                                    <i class="fz-12">Se enviará un correo electrónico con los pasos para actualizar su contraseña.</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-linea p-t-10">
                        <div class="form-columna">
                            <label for="email" class="form-label">Ingrese su cuenta de correo</label>
                            <input class="form-input" type="email" name="email_password_reset" value=""  autocomplete="off" placeholder="Correo Electrónico" required>
                            @if (session('error'))
                                <span class=form-error>El Correo ingresado no existe en el registro de usuarios</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-linea">
                        <div class="form-columna">

                        </div>
                    </div>
                </div>
                <div class="form-foot p-10">
                    <div class="form-linea flex flex-space-between flex-item-center">
                        <div class="form-columna m-b-0">
                          <a href="{{ route('acceder') }}" class="link fz-12 txt-italic txt-rojo" style="color: var(--main-ppal-color">volver al login</a>
                        </div>
                        <div class="form-columna m-b-0">
                            <button>enviar</button>
                        </div>
                    </div>
                </div>
            </form>
{{--                <a href="{{ route('register') }}" class="link link_registrar margen-auto">
                    <div class="ancho-90 ancho-m-80 ancho-l-70 ancho-lg-60 margen-auto flex flex-space-between p-10" style="margin-top: 30px;">
                         <div class="ancho-30">
                            <img src="{{ Storage::url('login/registrar_mi_negocio.svg')  }}" alt="" class="ancho-100">
                        </div>
                        <div class="ancho-70 flex flex-item-center flex-content-center">
                            <span class="txt-blanco">Quiero registrar mi negocio</span>
                        </div>
                    </div>
                </a> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('js/app.js') }}"></script>
{{--     @if (session('error'))
        <script>
            Swal.fire(
              'Error de Autentificación',
              '{{ session('error') }}',
              'error'
            )
        </script>
    @endif --}}
    <style>
           .link_registrar:hover>div{
            background: var(--main-ppal-color);
            border-radius: 7px;
            border: 1px solid white;
            opacity: .7;
        }
        .ocultar {
            display: none;
        }
    </style>
</body>
</html>