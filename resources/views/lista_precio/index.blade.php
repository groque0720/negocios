@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	<div class="ancho-95 ancho-sx-95 ancho-s-90 ancho-m-90 ancho-l-85 ancho-lg-80">
		<lista-precio v-bind:tipo_id="'1'" v-bind:negocio="{{ $negocio }}" ></lista-precio>
	</div>
@endsection