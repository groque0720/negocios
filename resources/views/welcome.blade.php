<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tu Vidriera en Internet</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <meta id="token" name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Tu negocio en Internet a vista de todos" />
<meta property="og:description" content="Facil, rápido y sencillo de mostrar tus productos" />
<meta property="og:url" content="https://vidriera.ar/" />
<meta property="og:site_name" content="Alcanza más clientes | Aumenta tus ventas" />
<!-- Para facebook, SMS -->
{{-- <meta property="og:image" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:secure_url" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="Neveras para hostelería, Wondercool" /> --}}
<!-- Para twitter -->
{{-- <meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Las bebidas más frías del mundo" />
<meta name="twitter:title" content="Neveras inteligentes para hostelería" />
<meta name="twitter:image" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1024x512.png" /> --}}
<!-- Para whatsapp -->
{{-- <meta property="og:site_name" content="San Roque 2014 Pollos"> --}}
{{-- <meta property="og:title" content="San Roque 2014 Pollos" />
<meta property="og:description" content="Programa de fiestas" /> --}}
<meta property="og:image" itemprop="image" content="https://vidriera.ar/logo.png">
<meta property="og:type" content="website" />
{{-- <meta property="og:updated_time" content="1440432930" /> --}}

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            .svg-content {
              position: absolute;
              top:50%;
              left: 50%;
              transform: translate(-50%, -50%);
            }

            .title {
              text-align: center;
              color: white;
            }
        </style>
    </head>
    <body>
        <div id="app">
           <div class="flex-center position-ref full-height">
                @if (Route::has('acceder'))
                    <div class="top-right links">
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('acceder') }}">Login</a>
                            <a href="{{ route('register') }}">Register</a>
                        @endauth
                    </div>
                @endif
                <div class="content">
                    <example-component></example-component>
                    <validador ref="validador" :mostrar_validador="true"></validador>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
