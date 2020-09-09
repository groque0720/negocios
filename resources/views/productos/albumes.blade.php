@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')
	<div class="ancho-95">
		<productos v-bind:tipo_id="'2'"></productos>
	</div>
@endsection