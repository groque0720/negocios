@extends('public.layouts.app')

@section('title', $negocio->nombre)

@section('contenido')

	<layout-producto v-bind:negocio="{{ $negocio }}" v-bind:producto="{{ $producto }}" v-bind:imagen_id="{{ $imagen_id }}"></layout-producto>

@endsection