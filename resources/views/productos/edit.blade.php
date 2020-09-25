@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	<div class="ancho-95 ancho-sx-95 ancho-s-90 ancho-m-80 ancho-l-70 ancho-lg-60 flex flex-content-center" style="overflow: hidden;">
		<producto-formulario v-bind:producto="{{ $producto }}" v-bind:negocio="{{ $negocio }}"></producto-formulario>
	</div>
@endsection