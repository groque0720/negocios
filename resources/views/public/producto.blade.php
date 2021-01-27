@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('metas')
	{{-- <title>your keyword rich title of the website and/or webpage</title> --}}
	<!-- MS, fb & Whatsapp -->
	<!-- MS Tile - for Microsoft apps-->
	<meta name="msapplication-TileImage" content="https://vidriera.ar/storage/{{ $imagen_url }}">
	<!-- fb & Whatsapp -->
	<!-- Site Name, Title, and Description to be displayed -->
	<meta property="og:site_name" content="{{ $negocio->nombre }}">
	<meta property="og:title" content="{{ $producto->producto }}">
	<meta property="og:description" content="{{ $producto->descripcion }}">
	<!-- Image to display -->
	<meta property="og:image" content="https://vidriera.ar/storage/{{ $imagen_url }}">
	<!-- No need to change anything here -->
	<meta property="og:type" content="website" />
	<meta property="og:image:type" content="image/jpeg">
	<!-- Size of image. Any size up to 300. Anything above 300px will not work in WhatsApp -->
	<meta property="og:image:width" content="300">
	<meta property="og:image:height" content="300">
	<!-- Website to visit when clicked in fb or WhatsApp-->
	<meta property="og:url" content="https://vidriera.ar/{{ $negocio->url }}/producto/{{ $producto->codigo }}/{{ $imagen_id }}">
@endsection

@section('contenido')

	<layout-producto v-bind:negocio="{{ $negocio }}" v-bind:producto="{{ $producto }}" v-bind:imagen_id="{{ $imagen_id }}"></layout-producto>

@endsection