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
<title>your keyword rich title of the website and/or webpage</title>
{{-- <meta name="description" content="description of your website/webpage, make sure you use keywords!">
<meta property="og:title" content="short title of your website/webpage" />
<meta property="og:url" content="https://vidriera.online/ideasenlaser/" />
<meta property="og:type" content="website" />
<meta property="og:description" content="description of your website/webpage">
<meta property="og:image:secure_url" content="https://vidriera.online/images/pp.jpg">
<meta property="og:image" itemprop="image" content="https://vidriera.online/images/pp.jpg">
<meta property="og:type" content="article" />
<meta property="og:locale" content="en_GB" />
<meta property="og:locale:alternate" content="fr_FR" />
<meta property="og:locale:alternate" content="es_ES" /> --}}

<!-- MS, fb & Whatsapp -->

<!-- MS Tile - for Microsoft apps-->
<meta name="msapplication-TileImage" content="https://vidriera.online/images/pp.jpg">

<!-- fb & Whatsapp -->

<!-- Site Name, Title, and Description to be displayed -->
<meta property="og:site_name" content="The Rock Photo Studio">
<meta property="og:title" content="The Rock Photo Studio in Florida">
<meta property="og:description" content="The best photo studio for your events">

<!-- Image to display -->
<!-- Replace   «example.com/image01.jpg» with your own -->
<meta property="og:image" content="https://vidriera.online/images/pp.jpg">

<!-- No need to change anything here -->
<meta property="og:type" content="website" />
<meta property="og:image:type" content="image/jpeg">

<!-- Size of image. Any size up to 300. Anything above 300px will not work in WhatsApp -->
<meta property="og:image:width" content="300">
<meta property="og:image:height" content="300">

<!-- Website to visit when clicked in fb or WhatsApp-->
<meta property="og:url" content="https://vidriera.online/ideasenlaser">


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
