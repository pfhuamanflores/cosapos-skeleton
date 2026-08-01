@extends('layouts.app')
@section('titulo', 'Proyectos')
@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Proyectos</h3>
    <a href="{{ route('proyectos.create') }}" class="btn btn-primary">Nuevo proyecto</a>
</div>

<form class="mb-3" method="GET">
    <input type="text" name="buscar" class="form-control" placeholder="Buscar por nombre o código" value="{{ request('buscar') }}">
</form>

<div class="table-responsive">
<table class="table table-striped bg-white">
    <thead><tr><th>Código</th><th>Nombre</th><th>Cliente</th><th>Inicio</th><th>Margen base</th><th></th></tr></thead>
    <tbody>
    @foreach($proyectos as $proyecto)
        <tr>
            <td>{{ $proyecto->codigo }}</td>
            <td>{{ $proyecto->nombre }}</td>
            <td>{{ $proyecto->cliente }}</td>
            <td>{{ $proyecto->fecha_inicio->format('d/m/Y') }}</td>
            <td>{{ $proyecto->resultadoOperativo ? number_format($proyecto->resultadoOperativo->margen * 100, 1).'%' : '—' }}</td>
            <td>
                <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                <a href="{{ route('proyectos.edit', $proyecto) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
{{ $proyectos->links() }}
@endsection
