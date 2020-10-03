 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/favicon.png"/>
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
{{--     <meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Neveras inteligentes para hostelería" />
<meta property="og:description" content="Las bebidas más frías del mundo" />
<meta property="og:url" content="https://wondercool.eu/" />
<meta property="og:site_name" content="Wondercool | Neveras inteligentes" />
<!-- Para facebook, SMS -->
<meta property="og:image" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:secure_url" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1200x630.png" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:image:alt" content="Neveras para hostelería, Wondercool" />
<!-- Para twitter -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Las bebidas más frías del mundo" />
<meta name="twitter:title" content="Neveras inteligentes para hostelería" />
<meta name="twitter:image" content="https://wondercool.eu/wp-content/uploads/2019/01/logo-wondercool-redes-sociales-3-lineas-original-1024x512.png" />
<!-- Para whatsapp -->
<meta property="og:site_name" content="San Roque 2014 Pollos">
<meta property="og:title" content="San Roque 2014 Pollos" />
<meta property="og:description" content="Programa de fiestas" />
<meta property="og:image" itemprop="image" content="http://pollosweb.wesped.es/programa_pollos/play.png">
<meta property="og:type" content="website" />
<meta property="og:updated_time" content="1440432930" /> --}}
</head>
<body>
    <div id="app">
                <a class="ir-arriba" title="Volver arriba">
                    <div class="flex flex-content-center flex-item-center">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                </a>
        <div class="margen-auto flex flex-space-between flex-direction-column" style="min-height: 100vh;">
            <div class="ancho-100 flex flex-direction-column">
                <header class="m-b-5">
                   @include('layouts.parciales.cabecera')
                </header>
                <section class="flex m-h-10" style="margin-top: 60px; position: relative;">
                    {{-- <validador></validador> --}}
                    @include('layouts.parciales.mensajes')
                    <div class="menu-lateral-lg no-display-m" style="width: 250px; margin-right: 30px; position: fixed; left: 0;">
                         @include('layouts.parciales.menu-lateral')
                    </div>
                    <div class="flex flex-content-center ancho-100 p-t-10 m-r-250-display-m">
                         @yield('contenido')
                    </div>
                </section>
            </div>
{{--             <footer class="flex-item-end">
                productos 2019
            </footer> --}}
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @yield('script')
    @yield('estilos')
</body>
</html>
