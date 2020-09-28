@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('metas');


{{-- <meta property="keywords" content="recitales por streaming,+Vivo,recitales,streaming,BTS"/>
<meta name="description" content="{!! $negocio->descripcion !!}"/>
<meta name="robots" content="index, follow"/>
<meta name="distribution" content="global"/>
<meta name="rating" content="general"/>
<meta name="language" content="es_ES"/>
<meta name="news_keywords" content=""/> --}}
{{-- <meta name="twitter:title" content="{!! $negocio->negocio !!}"/>
<meta name="twitter:site" content="@infobae"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:creator" content="@infobae"/>
<meta name="twitter:image" content="https://vidriera.online/storage/{!! $negocio->logo !!}"/>
<meta name="twitter:description" content="https://vidriera.online/storage/{!! $negocio->logo !!}"/> --}}

<meta property="og:title" content="Recitales por streaming: cómo se adapta la industria musical ante la “nueva normalidad”"/>
<meta property="og:description" content="{!! $negocio->descripcion !!}"/>
<meta property="og:url" content="https://vidriera.online/{!! $negocio->url !!}"/>
<meta property="og:type" content="article"/>
<meta property="og:site_name" content="{!! $negocio->negocio !!}"/>
<meta property="og:locale" content="es_LA"/>
<meta itemProp="image" property="og:image" content="/storage/{!! $negocio->logo !!}"/>
<meta property="og:image:secure_url" content="/storage/{!! $negocio->logo !!}" />
{{-- <meta name="isDFP" content="true"/>
<meta name="dfpPageType" content="nota"/>
<meta name="dfp_path" content="infobae/inhouse"/><meta property="article:publisher" content="https://www.facebook.com/infobae"/> --}}


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