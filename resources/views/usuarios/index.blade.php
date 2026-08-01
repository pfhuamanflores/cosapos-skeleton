@extends('layouts.app')
@section('titulo', 'Usuarios')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Usuarios</h3>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">Nuevo usuario</a>
</div>

<form class="mb-3" method="GET">
    <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o correo" value="{{ request('buscar') }}">
</form>

<table class="table table-striped bg-white">
    <thead><tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Estado</th><th></th></tr></thead>
    <tbody>
    @foreach($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
            <td>{{ $usuario->correo }}</td>
            <td>{{ $usuario->rol->nombre }}</td>
            <td>
                <span class="badge bg-{{ $usuario->activo ? 'success' : 'secondary' }}">
                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </td>
            <td class="text-end">
                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                @if($usuario->activo)
                <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Inactivar usuario?')">Inactivar</button>
                </form>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $usuarios->links() }}
@endsection
