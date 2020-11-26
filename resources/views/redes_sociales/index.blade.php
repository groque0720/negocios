@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	<div class="ancho-95 ancho-sx-95 ancho-s-90 ancho-m-90 ancho-l-85 ancho-lg-80">
		<redes-sociales-negocio v-bind:negocio="{{ $negocio }}" v-bind:redes="{{ $redes_sociales }}" v-bind:redes_negocio="{{ $redes_sociales_negocio }}"></redes-sociales-negocio>
	</div>
@endsection