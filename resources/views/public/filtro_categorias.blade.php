@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('metas')

	{{-- <title>your keyword rich title of the website and/or webpage</title> --}}
	<meta property="og:image" content="https://vidriera.ar/storage/{{$negocio->logo}}" />
	<meta property="og:image:secure_url" content="https://vidriera.ar/storage/{{$negocio->logo}}" />
	<!-- MS, fb & Whatsapp -->
	<!-- MS Tile - for Microsoft apps-->
	<meta name="msapplication-TileImage" content="https://vidriera.ar/storage/{{$negocio->logo}}">
	<!-- fb & Whatsapp -->
	<!-- Site Name, Title, and Description to be displayed -->
	<meta property="og:site_name" content="{{ $negocio->nombre }}">
	<meta property="og:title" content="{{ $negocio->nombre }}">
	<meta property="og:description" content="{{ $negocio->descripcion }}">
	<!-- Image to display -->
	<meta property="og:image" content="https://vidriera.ar/storage/{{$negocio->logo}}">
	<!-- No need to change anything here -->
	<meta property="og:type" content="website" />
	<meta property="og:image:type" content="image/jpeg">
	<!-- Size of image. Any size up to 300. Anything above 300px will not work in WhatsApp -->
	<meta property="og:image:width" content="300">
	<meta property="og:image:height" content="300">
	<!-- Website to visit when clicked in fb or WhatsApp-->
	<meta property="og:url" content="https://vidriera.ar/{{ $negocio->url }}">
@endsection

@section('contenido')
<div>



	{{-- <layout-public v-bind:negocio="{{ $negocio }}"></layout-public> --}}
	{{-- <layout-grid-columnas v-bind:negocio="{{ $negocio }}"></layout-grid-columnas> --}}
	<layout-productos-filtro-categorias v-bind:negocio="{{ $negocio }}"  v-bind:categoria="'{{ $categoria }}'"></layout-productos-filtro-categorias>

</div>

@endsection