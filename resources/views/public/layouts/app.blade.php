<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ Storage::url($negocio->logo) }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Neveras inteligentes para hostelería" />
<meta property="og:description" content="Las bebidas más frías del mundo" />
<meta property="og:url" content="https://vidriera.online/" />
<meta property="og:site_name" content="Wondercool | Neveras inteligentes" />
<!-- Para whatsapp -->
<meta property="og:image" content="https://vidriera.online/storage/ideas-en-laser/da2251e6f6dfcb3dca7f4c38265b3e3d.jpg" />
<meta property="og:image:secure_url" content="https://vidriera.online/storage/ideas-en-laser/da2251e6f6dfcb3dca7f4c38265b3e3d.jpg" />
<meta property="og:image:type" content="image/jpg" />
<meta property="og:image:width" content="300" />
<meta property="og:image:height" content="300" />
</head>
<body class="scrollbar" id="style-3">
    <div id="app">
{{--         <a class="ir-arriba" title="Volver arriba">
            <div class="flex flex-content-center flex-item-center">
                <i class="fas fa-arrow-up"></i>
            </div>
        </a> --}}
        <div class="margen-auto flex flex-space-between flex-direction-column" style="min-height: 100vh;">
            <div class="ancho-100 flex flex-direction-column">
                <header class="m-b-5">
                   @include('public.layouts.parciales.cabecera')
                </header>
                <section class="flex flex-content-center" style="margin-top: 55px;">
                   {{--  @include('public.layouts.parciales.mensajes') --}}
                    @yield('contenido')
                </section>
            </div>
            <footer class="flex-item-end">
                productos 2020
            </footer>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    @yield('script')
    @yield('estilos')
</body>
</html>
