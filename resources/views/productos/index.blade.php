@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	{{-- <div class="ancho-sx-95 ancho-s-90 ancho-m-85 ancho-l-80 ancho-lg-75"> --}}
	<div class="ancho-95 ancho-sx-95 ancho-s-90 ancho-m-90 ancho-l-85 ancho-lg-80">
		<productos v-bind:tipo_id="'1'" v-bind:negocio="{{ $negocio }}"></productos>
	</div>
@endsection