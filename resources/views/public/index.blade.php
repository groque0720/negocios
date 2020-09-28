@extends('public.layouts.app')

@section('title', $negocio->nombre)


@section('metas')

	<title>your keyword rich title of the website and/or webpage</title>

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
@endsection

@section('metasrr');



	{{-- <title>your keyword rich title of the website and/or webpage</title> --}}
	<meta property="og:image" content="https://vidriera.online/storage/{{$negocio->logo}}" />
	<meta property="og:image:secure_url" content="https://vidriera.online/storage/{{$negocio->logo}}" />
	<!-- MS, fb & Whatsapp -->
	<!-- MS Tile - for Microsoft apps-->
	<meta name="msapplication-TileImage" content="https://vidriera.online/storage/{{$negocio->logo}}">
	<!-- fb & Whatsapp -->
	<!-- Site Name, Title, and Description to be displayed -->
	<meta property="og:site_name" content="{{ $negocio->nombre }}">
	<meta property="og:title" content="{{ $negocio->nombre }}">
	<meta property="og:description" content="{{ $negocio->descripcion }}">
	<!-- Image to display -->
	<meta property="og:image" content="https://vidriera.online/storage/{{$negocio->logo}}">
	<!-- No need to change anything here -->
	<meta property="og:type" content="website" />
	<meta property="og:image:type" content="image/jpeg">
	<!-- Size of image. Any size up to 300. Anything above 300px will not work in WhatsApp -->
	<meta property="og:image:width" content="300">
	<meta property="og:image:height" content="300">
	<!-- Website to visit when clicked in fb or WhatsApp-->
	<meta property="og:url" content="https://vidriera.online/{{ $negocio->url }}">
@endsection

@section('contenido')

	<layout-public v-bind:negocio="{{ $negocio }}"></layout-public>
	{{-- <layout-grid-columnas v-bind:negocio="{{ $negocio }}"></layout-grid-columnas> --}}

@endsection