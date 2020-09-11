@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('contenido')

	<layout-columnas v-bind:negocio="{{ $negocio }}"></layout-columnas>

@endsection