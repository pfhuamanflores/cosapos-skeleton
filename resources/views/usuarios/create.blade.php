@extends('layouts.app')
@section('titulo', 'Nuevo usuario')
@section('contenido')
<h3>Nuevo usuario</h3>
<form method="POST" action="{{ route('usuarios.store') }}" class="bg-white p-4 rounded shadow-sm">
    @csrf
    @include('usuarios._form')
    <button class="btn btn-primary">Guardar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-link">Cancelar</a>
</form>
@endsection
