@extends('layouts.app')
@section('titulo', 'Proyectos')
@section('contenido')
<x-page-header eyebrow="Gestión" title="Proyectos" description="Administra y supervisa el portafolio de proyectos de ingeniería.">
    @can('create', \App\Models\Proyecto::class)<a href="{{ route('proyectos.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i>Nuevo proyecto</a>@endcan
</x-page-header>

<section class="surface-card">
    <div class="project-toolbar">
        <form method="GET" class="project-search"><i class="bi bi-search"></i><input name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o código…" aria-label="Buscar proyectos"><button class="btn btn-primary" type="submit">Buscar</button></form>
        <div class="toolbar-meta"><span><i class="bi bi-kanban"></i>{{ $proyectos->total() }} proyectos</span></div>
    </div>
    <div class="table-responsive mobile-cards">
        <table class="table project-table align-middle">
            <thead><tr><th>Proyecto</th><th>Estado</th><th>Avance</th><th>Presupuesto</th><th>Ejecutado</th><th>Variación</th><th>Actualización</th><th></th></tr></thead>
            <tbody>
            @forelse($proyectos as $proyecto)
                @php
                    $mensual = $proyecto->resultadosOperativosMensuales->first();
                    $avance = ($mensual?->avance_fisico ?? 0) * 100;
                    $presupuesto = (float) ($proyecto->resultadoOperativo?->costo_total ?? 0);
                    $ejecutado = (float) ($mensual?->costo_total_acumulado ?? 0);
                    $variacion = $presupuesto > 0 ? (($ejecutado / $presupuesto) - ($avance / 100)) * 100 : 0;
                @endphp
                <tr>
                    <td data-label="Proyecto"><div class="project-cell"><span class="project-avatar">{{ strtoupper(substr($proyecto->nombre,0,2)) }}</span><span><a href="{{ route('proyectos.show',$proyecto) }}">{{ $proyecto->nombre }}</a><small>{{ $proyecto->codigo }} · {{ $proyecto->cliente }}</small></span></div></td>
                    <td data-label="Estado"><span class="status-pill status-active"><i></i>En ejecución</span></td>
                    <td data-label="Avance"><div class="table-progress"><span><strong>{{ number_format($avance,0) }}%</strong></span><div class="progress"><div class="progress-bar" style="width:{{ min($avance,100) }}%"></div></div></div></td>
                    <td data-label="Presupuesto">{{ $presupuesto ? 'S/ '.number_format($presupuesto,0,',','.') : '—' }}</td>
                    <td data-label="Ejecutado">{{ $ejecutado ? 'S/ '.number_format($ejecutado,0,',','.') : '—' }}</td>
                    <td data-label="Variación"><span class="variance {{ $variacion > 0 ? 'negative' : 'positive' }}">{{ $mensual ? ($variacion > 0 ? '+' : '').number_format($variacion,1).'%' : '—' }}</span></td>
                    <td data-label="Actualización">{{ $proyecto->updated_at->format('d/m/Y') }}</td>
                    <td data-label="Acciones"><div class="dropdown"><button class="action-menu" data-bs-toggle="dropdown" aria-label="Acciones de {{ $proyecto->nombre }}"><i class="bi bi-three-dots"></i></button><ul class="dropdown-menu dropdown-menu-end"><li><a class="dropdown-item" href="{{ route('proyectos.show',$proyecto) }}"><i class="bi bi-eye"></i>Ver detalle</a></li>@can('update',$proyecto)<li><a class="dropdown-item" href="{{ route('proyectos.edit',$proyecto) }}"><i class="bi bi-pencil"></i>Editar</a></li>@endcan @can('delete',$proyecto)<li><hr class="dropdown-divider"></li><li><form method="POST" action="{{ route('proyectos.destroy',$proyecto) }}" onsubmit="return confirm('¿Eliminar este proyecto? Esta acción no se puede deshacer.')">@csrf @method('DELETE')<button class="dropdown-item text-danger"><i class="bi bi-trash"></i>Eliminar</button></form></li>@endcan</ul></div></td>
                </tr>
            @empty
                <tr><td colspan="8"><div class="empty-state p-5 text-center"><i class="bi bi-search"></i><p class="fw-semibold mb-1">No encontramos proyectos</p><span>Prueba con otro término de búsqueda.</span></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="surface-pagination">{{ $proyectos->links() }}</div>
</section>
@endsection
