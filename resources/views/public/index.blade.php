@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('metas');
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




<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=0.5, maximum-scale=2.0"/>
<meta property="keywords" content="recitales por streaming,+Vivo,recitales,streaming,BTS"/>
<meta name="description" content="En el actual contexto de coronavirus, los shows en vivo encontraron una posibilidad de reinvención en las transmisiones online. El testimonio de Eduardo Basagaña, fundador de +VIVO, la plataforma líder en Latinoamérica, sobre el enorme potencial del negocio y la emoción que le genera poder crear fuentes de trabajo en estos momentos"/>
<meta name="robots" content="index, follow"/>
<meta name="distribution" content="global"/>
<meta name="rating" content="general"/>
<meta name="language" content="es_ES"/>
<meta name="news_keywords" content=""/>
<meta name="twitter:title" content="Recitales por streaming: cómo se adapta la industria musical ante la “nueva normalidad”"/>
<meta name="twitter:site" content="@infobae"/>
<meta name="twitter:card" content="summary_large_image"/>
<meta name="twitter:creator" content="@infobae"/>
<meta name="twitter:image" content="https://www.infobae.com/new-resizer/iHKR1bFGHCL1ZN1YM5PfxGBmU_0=/1024x512/filters:format(jpg):quality(85)//cloudfront-us-east-1.images.arcpublishing.com/infobae/6WA4QRFGT5CJJNJXHWFSUPOPMM.jpg"/>
<meta name="twitter:description" content="En el actual contexto de coronavirus, los shows en vivo encontraron una posibilidad de reinvención en las transmisiones online. El testimonio de Eduardo Basagaña, fundador de +VIVO, la plataforma líder en Latinoamérica, sobre el enorme potencial del negocio y la emoción que le genera poder crear fuentes de trabajo en estos momentos"/>

<meta property="og:title" content="Recitales por streaming: cómo se adapta la industria musical ante la “nueva normalidad”"/>
<meta property="og:description" content="En el actual contexto de coronavirus, los shows en vivo encontraron una posibilidad de reinvención en las transmisiones online. El testimonio de Eduardo Basagaña, fundador de +VIVO, la plataforma líder en Latinoamérica, sobre el enorme potencial del negocio y la emoción que le genera poder crear fuentes de trabajo en estos momentos"/>
<meta property="og:url" content="/inhouse/2020/09/28/recitales-por-streaming-como-se-adapta-la-industria-musical-ante-la-nueva-normalidad/"/>
<meta property="og:type" content="article"/><meta property="og:site_name" content="infobae"/>
<meta property="og:locale" content="es_LA"/>
<meta itemProp="image" property="og:image" content="https://www.infobae.com/new-resizer/pFM2MDkajHQck1jmFcb6yMXTquQ=/1200x628/filters:format(jpg):quality(85)//cloudfront-us-east-1.images.arcpublishing.com/infobae/6WA4QRFGT5CJJNJXHWFSUPOPMM.jpg"/>
<meta name="isDFP" content="true"/>
<meta name="dfpPageType" content="nota"/>
<meta name="dfp_path" content="infobae/inhouse"/><meta property="article:publisher" content="https://www.facebook.com/infobae"/>








@endsection

@section('contenido')

	<layout-public v-bind:negocio="{{ $negocio }}"></layout-public>
	{{-- <layout-grid-columnas v-bind:negocio="{{ $negocio }}"></layout-grid-columnas> --}}

@endsection