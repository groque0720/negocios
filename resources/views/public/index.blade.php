@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('contenido')

	{{-- <layout-public v-bind:negocio="{{ $negocio }}"></layout-public> --}}
	<layout-grid-columnas v-bind:negocio="{{ $negocio }}"></layout-grid-columnas>

@endsection