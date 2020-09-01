@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	<div class="ancho-95">
		<categorias></categorias>
	</div>
@endsection