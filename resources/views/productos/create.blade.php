@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	<div class="ancho-95">
		<div>
			<h1 class="txt-centrar">Nuevo Producto</h1>
		</div>
		<producto-formulario v-bind:producto="{{ $producto }}" v-bind:negocio="{{ $negocio }}"></producto-formulario>
	</div>
@endsection