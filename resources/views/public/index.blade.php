@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('metas');




    <meta property="og:locale" content="es_ES">
    <meta property="og:type" content="article">
    <meta property="og:title" content="12 Leyes de la experiencia de usuario UX - Eniun">
    <meta property="og:description" content="Las 12 leyes más importantes de la experiencia de usuario UX. Las reglas que nos sirven de guía para generar percepciones positivas en las personas cuando interactúen con nuestros productos. Eniun, expertos en experiencia de usuario y usabilidad web.">
    <meta property="og:url" content="https://www.eniun.com/12-leyes-experiencia-de-usuario-ux/">
    <meta property="og:site_name" content="Eniun">
    <meta property="article:publisher" content="https://www.facebook.com/eniun.es">
    <meta property="article:section" content="UX">
    <meta property="article:published_time" content="2018-02-28T09:00:04+00:00">
    <meta property="article:modified_time" content="2019-08-22T19:41:17+00:00">
    <meta property="og:updated_time" content="2019-08-22T19:41:17+00:00">
    <meta property="og:image" content="https://www.eniun.com/wp-content/uploads/12-leyes-de-la-experiencia-de-usuario-UX.jpg">
    <meta property="og:image:secure_url" content="https://www.eniun.com/wp-content/uploads/12-leyes-de-la-experiencia-de-usuario-UX.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">
















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