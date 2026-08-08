@extends('layouts.app')

@section('titulo', 'Dashboard')

@section('contenido')

<div class="dashboard-header mb-4">
    <div>
        <span class="dashboard-overline">Panel ejecutivo</span>
        <h2 class="dashboard-title">
            Panel de control
        </h2>
        <p class="dashboard-subtitle">
            Resumen general del estado de los proyectos y operaciones.
        </p>
    </div>
</div>


<div class="row g-4 mb-4">
    {{-- Proyectos --}}
    <div class="col-md-4">
        <div class="kpi-card kpi-projects">
            <div class="kpi-icon">
                <i class="bi bi-folder2-open"></i>
            </div>
            <div class="kpi-content">
                <span class="kpi-label">
                    Proyectos registrados
                </span>
                <h2 class="kpi-value">
                    {{ $totalProyectos }}
                </h2>
                <span class="kpi-description">
                    Total de proyectos registrados
                </span>
            </div>
        </div>
    </div>


    {{-- Alertas --}}
    <div class="col-md-4">
        <div class="kpi-card kpi-alerts">
            <div class="kpi-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="kpi-content">
                <span class="kpi-label">
                    Alertas activas
                </span>
                <h2 class="kpi-value">
                    {{ $alertasActivas }}
                </h2>
                <span class="kpi-description">
                    Incidencias que requieren atención
                </span>
            </div>
        </div>
    </div>


    {{-- Solicitudes --}}
    <div class="col-md-4">
        <div class="kpi-card kpi-requests">
            <div class="kpi-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="kpi-content">
                <span class="kpi-label">
                    Solicitudes pendientes
                </span>
                <h2 class="kpi-value">
                    {{ $solicitudesPendientes }}
                </h2>
                <span class="kpi-description">
                    Solicitudes pendientes por atender
                </span>
            </div>
        </div>
    </div>
</div>


<div class="dashboard-panel">
    <div class="dashboard-panel-header">
        <div>
            <span class="dashboard-panel-overline">
                Actividad reciente
            </span>
            <h5 class="dashboard-panel-title">
                Proyectos recientes
            </h5>
        </div>
        <a
            href="{{ route('proyectos.index') }}"
            class="btn btn-sm btn-outline-primary dashboard-view-all"
        >
            Ver todos
        </a>
    </div>

    <div class="table-responsive">
        <table class="table dashboard-table align-middle mb-0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Proyecto</th>
                    <th>Cliente</th>
                    <th>Margen base</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proyectosRecientes as $proyecto)
                    <tr>
                        <td>
                            <span class="project-code">
                                {{ $proyecto->codigo }}
                            </span>
                        </td>
                        <td class="fw-semibold">
                            {{ $proyecto->nombre }}
                        </td>
                        <td>
                            {{ $proyecto->cliente }}
                        </td>
                        <td>
                            @if($proyecto->resultadoOperativo)

                                @php
                                    $margen = $proyecto->resultadoOperativo->margen * 100;
                                @endphp
                                <span class="
                                    badge
                                    {{ $margen >= 0
                                        ? 'text-bg-success'
                                        : 'text-bg-danger'
                                    }}
                                ">
                                    {{ number_format($margen, 1) }}%
                                </span>
                            @else
                                <span class="text-secondary">
                                    —
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a
                                href="{{ route('proyectos.show', $proyecto) }}"
                                class="btn btn-sm btn-outline-primary"
                            >
                                <i class="bi bi-eye me-1"></i>
                                Ver
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="5"
                            class="text-center py-5"
                        >
                            <div class="empty-state">
                                <i class="bi bi-folder2-open"></i>
                                <p class="mb-1 fw-semibold">
                                    No hay proyectos registrados
                                </p>
                                <span>
                                    Los proyectos recientes aparecerán aquí.
                                </span>

                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
