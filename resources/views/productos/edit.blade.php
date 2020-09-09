@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	<div class="ancho-95">
		<producto-formulario v-bind:producto="{{ $producto }}" v-bind:negocio="{{ $negocio }}"></producto-formulario>
	</div>
@endsection