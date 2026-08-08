@extends('layouts.app')
@section('titulo', 'Proyectos')
@section('contenido')
<div class="dashboard-header mb-4">
    <div>
        <span class="dashboard-overline">
            Gestión de proyectos
        </span>
        <h2 class="dashboard-title">
            Proyectos
        </h2>
        <p class="dashboard-subtitle">
            Administración y seguimiento de los proyectos de ingeniería.
        </p>
    </div>
</div>

<div class="dashboard-panel mb-4">
    <div class="dashboard-panel-header">
        <div>
            <span class="dashboard-panel-overline">
                Gestión
            </span>
            <h5 class="dashboard-panel-title">
                Lista de los proyectos
            </h5>
        </div>
        <a
            href="{{ route('proyectos.create') }}"
            class="btn btn-primary"
        >
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo proyecto
        </a>
    </div>

    <div class="p-4">
        <form method="GET">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    name="buscar"
                    class="form-control"
                    placeholder="Buscar por nombre o código..."
                    value="{{ request('buscar') }}"
                >
            </div>
        </form>
    </div>

<div class="table-responsive px-4 pb-4">
<table class="table dashboard-table align-middle mb-0">
    <thead><tr><th>Código</th><th>Nombre</th><th>Cliente</th><th>Inicio</th><th>Margen base</th><th class="text-end">Acciones</th></tr></thead>
    <tbody>
    @foreach($proyectos as $proyecto)
        <tr>
            <td>{{ $proyecto->codigo }}</td>
            <td>{{ $proyecto->nombre }}</td>
            <td>{{ $proyecto->cliente }}</td>
            <td>{{ $proyecto->fecha_inicio->format('d/m/Y') }}</td>
            <td>{{ $proyecto->resultadoOperativo ? number_format($proyecto->resultadoOperativo->margen * 100, 1).'%' : '—' }}</td>
            <td class="text-end">
                <a
                    href="{{ route('proyectos.show', $proyecto) }}"
                    class="btn btn-sm btn-outline-primary"
                    title="Ver proyecto"
                >
                    <i class="bi bi-eye"></i>
                </a>

                <a
                    href="{{ route('proyectos.edit', $proyecto) }}"
                    class="btn btn-sm btn-outline-secondary ms-1"
                    title="Editar proyecto"
                >
                    <i class="bi bi-pencil"></i>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>
{{ $proyectos->links() }}
</div>
@endsection
