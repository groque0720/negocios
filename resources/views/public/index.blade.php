@extends('layouts.app')

@section('title', $negocio->nombre)

@section('contenido')

	<layout-columnas v-bind:productos="{{ $productos }}" v-bind:negocio="{{ $negocio }}"></layout-columnas>

@endsection