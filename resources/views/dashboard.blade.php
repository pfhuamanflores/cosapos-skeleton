@extends('layouts.app')
@section('titulo', 'Dashboard')
@section('contenido')
<x-page-header eyebrow="Panel ejecutivo" title="Bienvenido, {{ auth()->user()->nombre }}" description="Resumen general de proyectos y operaciones.">
    <button class="btn btn-outline-secondary" type="button"><i class="bi bi-calendar3"></i>{{ now()->translatedFormat('F Y') }}</button>
</x-page-header>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3"><x-stat-card label="Proyectos activos" :value="$totalProyectos" icon="bi-kanban" trend="12%" caption="vs. periodo anterior" /></div>
    <div class="col-sm-6 col-xl-3"><x-stat-card label="Presupuesto total" :value="'S/ '.number_format($presupuestoTotal / 1000000, 2).'M'" icon="bi-wallet2" tone="green" trend="8%" caption="cartera vigente" /></div>
    <div class="col-sm-6 col-xl-3"><x-stat-card label="Costo ejecutado" :value="'S/ '.number_format($costoEjecutado / 1000000, 2).'M'" icon="bi-graph-up-arrow" tone="amber" caption="acumulado registrado" /></div>
    <div class="col-sm-6 col-xl-3"><x-stat-card label="Avance promedio" :value="number_format($avancePromedio * 100, 0).'%'" icon="bi-speedometer2" tone="blue" trend="5%" caption="avance físico" /></div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-8">
        <section class="surface-card h-100">
            <div class="surface-header"><div><h2 class="surface-title">Avance de proyectos</h2><p class="surface-subtitle">Evolución consolidada de los últimos seis meses</p></div><span class="badge bg-primary-subtle text-primary">Mensual</span></div>
            <div class="p-4">
                <svg viewBox="0 0 720 250" class="w-100 dashboard-chart" role="img" aria-label="Gráfico de avance de proyectos de enero a junio">
                    <defs><linearGradient id="chartFill" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#3b82f6" stop-opacity=".24"/><stop offset="1" stop-color="#3b82f6" stop-opacity="0"/></linearGradient></defs>
                    @foreach([40,85,130,175,220] as $y)<line x1="42" y1="{{ $y }}" x2="700" y2="{{ $y }}" stroke="#e8edf3" stroke-width="1"/>@endforeach
                    <path d="M45 205 C100 198 120 180 175 174 S250 145 305 151 S385 110 435 118 S520 83 565 91 S650 52 698 60 L698 225 L45 225Z" fill="url(#chartFill)"/>
                    <path d="M45 205 C100 198 120 180 175 174 S250 145 305 151 S385 110 435 118 S520 83 565 91 S650 52 698 60" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round"/>
                    @foreach(['Ene','Feb','Mar','Abr','May','Jun'] as $i => $mes)<text x="{{ 45 + $i * 130 }}" y="244" fill="#64748b" font-size="11">{{ $mes }}</text>@endforeach
                </svg>
            </div>
        </section>
    </div>
    <div class="col-xl-4">
        <section class="surface-card h-100">
            <div class="surface-header"><div><h2 class="surface-title">Distribución de costos</h2><p class="surface-subtitle">Participación por categoría</p></div></div>
            <div class="cost-chart-wrap p-4">
                <div class="cost-donut" role="img" aria-label="Mano de obra 35%, materiales 30%, equipos 20%, subcontratos 10%, otros 5%"><div><strong>100%</strong><span>Costos</span></div></div>
                <div class="chart-legend">
                    @foreach([['Mano de obra','35%','legend-1'],['Materiales','30%','legend-2'],['Equipos','20%','legend-3'],['Subcontratos','10%','legend-4'],['Otros','5%','legend-5']] as [$label,$value,$class])
                        <div><span class="legend-dot {{ $class }}"></span><span>{{ $label }}</span><strong>{{ $value }}</strong></div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <section class="surface-card">
            <div class="surface-header"><div><h2 class="surface-title">Proyectos recientes</h2><p class="surface-subtitle">Seguimiento del portafolio activo</p></div><a href="{{ route('proyectos.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a></div>
            <div class="recent-projects">
                @forelse($proyectosRecientes as $proyecto)
                    @php($avance = ($proyecto->resultadosOperativosMensuales->first()?->avance_fisico ?? 0) * 100)
                    <a href="{{ route('proyectos.show', $proyecto) }}" class="recent-project-row">
                        <span class="project-monogram">{{ strtoupper(substr($proyecto->nombre,0,2)) }}</span>
                        <span class="project-main"><strong>{{ $proyecto->nombre }}</strong><small>{{ $proyecto->codigo }} · {{ $proyecto->cliente }}</small></span>
                        <span class="project-progress"><span><small>Avance</small><strong>{{ number_format($avance,0) }}%</strong></span><span class="progress"><span class="progress-bar" style="width: {{ min($avance,100) }}%"></span></span></span>
                        <span class="status-pill status-active">En ejecución</span><i class="bi bi-chevron-right"></i>
                    </a>
                @empty
                    <div class="empty-state p-5 text-center"><i class="bi bi-folder2-open"></i><p>No hay proyectos registrados.</p></div>
                @endforelse
            </div>
        </section>
    </div>
    <div class="col-xl-4">
        <section class="alerts-card h-100">
            <div class="alerts-header"><div><span>Monitoreo</span><h2>Alertas importantes</h2></div><span class="alerts-count">{{ $alertasActivas }}</span></div>
            <div class="alerts-list">
                @forelse($alertas as $alerta)
                    <article class="alert-item alert-critical"><i class="bi bi-exclamation-triangle-fill"></i><div><strong>{{ strtoupper($alerta->tipo) }}</strong><p>{{ $alerta->mensaje }}</p><small>{{ $alerta->resultadoOperativoMensual->proyecto->nombre }}</small></div></article>
                @empty
                    <div class="alert-empty"><i class="bi bi-shield-check"></i><strong>Todo bajo control</strong><span>No existen alertas activas.</span></div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
