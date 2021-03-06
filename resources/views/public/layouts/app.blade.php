 <!DOCTYPE html>
<html lang="es" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ Storage::url($negocio->logo) }}">
    @yield('metas')
{{--     <style>
        body {
            background-image: url("{{ Storage::url('logo_default_negocio.png') }}");
         }
    </style> --}}

</head>
<body class="scrollbar" id="style-3" style="background: #eee;">
    <img class="img-fondo" src="/images/fondo06.png" alt="">
    <div id="app">

        <a class="ir-arriba" title="Volver arriba">
            <div class="flex flex-content-center flex-item-center">
                <i class="fas fa-arrow-up"></i>
            </div>
        </a>
        <div class="margen-auto flex flex-space-between flex-direction-column" style="min-height: 100vh;">
            <div class="ancho-100 flex flex-direction-column">
                <header class="m-b-5">
                   @include('public.layouts.parciales.cabecera')
                </header>
                <section class="flex flex-content-center" style="margin-top: 60px;">
                   {{--  @include('public.layouts.parciales.mensajes') --}}
                    @yield('contenido')
                </section>
            </div>
            <footer class="flex-item-end">
                <div class="flex flex-item-center flex-content-center" style="height: 50px; background: #ddd;">
                    <span>{{ $negocio->nombre }} &copy {{ date('Y') }}</span>
                </div>
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
