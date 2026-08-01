@extends('layouts.app')
@section('titulo', 'Editar usuario')
@section('contenido')
<h3>Editar usuario</h3>
<form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="bg-white p-4 rounded shadow-sm">
    @csrf @method('PUT')
    @include('usuarios._form')
    <button class="btn btn-primary">Actualizar</button>
    <a href="{{ route('usuarios.index') }}" class="btn btn-link">Cancelar</a>
</form>
@endsection
