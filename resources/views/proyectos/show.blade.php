@extends('layouts.app')
@section('titulo', $proyecto->nombre)
@section('contenido')
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h4 mb-0">{{ $proyecto->codigo }} — {{ $proyecto->nombre }}</h1>
            <small class="text-muted">Cliente: {{ $proyecto->cliente }} · {{ $proyecto->ubicacion }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('proyectos.resumen', $proyecto) }}" class="btn btn-outline-primary btn-sm">Resumen ejecutivo</a>
            <a href="{{ route('proyectos.solicitudes.index', $proyecto) }}" class="btn btn-outline-secondary btn-sm">Solicitudes de recursos</a>
            @can('update', $proyecto)
                <a href="{{ route('proyectos.edit', $proyecto) }}" class="btn btn-outline-secondary btn-sm">Editar</a>
            @endcan
            @can('delete', $proyecto)
                <form method="POST" action="{{ route('proyectos.destroy', $proyecto) }}"
                      onsubmit="return confirm('¿Está seguro de eliminar este proyecto? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
                </form>
            @endcan
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Resultado Operativo Base (CUS08 / CUS13)</span>
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('proyectos.resultado.generarBase', $proyecto) }}">
                    @csrf
                    <button class="btn btn-sm btn-primary">Generar</button>
                </form>
                <form method="POST" action="{{ route('proyectos.resultado.actualizarBase', $proyecto) }}">
                    @csrf @method('PUT')
                    <button class="btn btn-sm btn-outline-primary">Recalcular</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if($proyecto->resultadoOperativo)
                <div class="row text-center">
                    <div class="col"><strong>Venta:</strong> {{ number_format($proyecto->resultadoOperativo->venta, 2) }}</div>
                    <div class="col"><strong>Costo total:</strong> {{ number_format($proyecto->resultadoOperativo->costo_total, 2) }}</div>
                    <div class="col"><strong>Utilidad:</strong> {{ number_format($proyecto->resultadoOperativo->utilidad, 2) }}</div>
                    <div class="col"><strong>Margen:</strong> {{ number_format($proyecto->resultadoOperativo->margen * 100, 2) }}%</div>
                </div>
            @else
                <p class="text-muted mb-0">Aún no se ha generado. Requiere venta contractual y presupuesto base registrados.</p>
            @endif
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header">Venta Contractual</div>
        <div class="card-body">
            @if($proyecto->ventaContractual)
                <p class="mb-2">Monto: {{ number_format($proyecto->ventaContractual->monto_contrato, 2) }} {{ $proyecto->tipo_moneda }}
                    — Firma: {{ $proyecto->ventaContractual->fecha_firma->format('d/m/Y') }}
                    — Estado: {{ $proyecto->ventaContractual->estado_contrato }}</p>
            @else
                <p class="text-muted mb-2">No registrada aún. Es requisito para poder generar el Resultado Operativo Base.</p>
            @endif
            <form method="POST" action="{{ route('proyectos.venta.store', $proyecto) }}" class="row g-2">
                @csrf
                <div class="col-md-3">
                    <input type="number" step="0.01" name="monto_contrato" class="form-control form-control-sm"
                           placeholder="Monto del contrato" value="{{ $proyecto->ventaContractual?->monto_contrato ?? '' }}" required>
                </div>
                <div class="col-md-3">
                    <input type="date" name="fecha_firma" class="form-control form-control-sm"
                           value="{{ $proyecto->ventaContractual?->fecha_firma?->format('Y-m-d') ?? '' }}" required>
                </div>
                <div class="col-md-3">
                    <select name="estado_contrato" class="form-select form-select-sm">
                        @foreach(['Vigente', 'Suspendido', 'Cerrado'] as $estado)
                            <option value="{{ $estado }}" @selected(($proyecto->ventaContractual?->estado_contrato ?? 'Vigente') === $estado)>{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-sm btn-primary w-100">{{ $proyecto->ventaContractual ? 'Actualizar' : 'Registrar' }}</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header">Plan de Fases (CUS05)</div>
        <div class="card-body">
            <table class="table table-sm">
                <thead><tr><th>Nombre</th><th>Área</th><th>Especialidad</th><th>Tipo de ejecución</th></tr></thead>
                <tbody>
                @forelse($proyecto->planFases as $fase)
                    <tr><td>{{ $fase->nombre }}</td><td>{{ $fase->area }}</td><td>{{ $fase->especialidad }}</td><td>{{ $fase->tipo_ejecucion }}</td></tr>
                @empty
                    <tr><td colspan="4" class="text-muted">Sin fases registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
            <form method="POST" action="{{ route('proyectos.fases.store', $proyecto) }}" class="row g-2">
                @csrf
                <div class="col-md-3"><input name="nombre" class="form-control form-control-sm" placeholder="Nombre de fase" required></div>
                <div class="col-md-3"><input name="area" class="form-control form-control-sm" placeholder="Área"></div>
                <div class="col-md-3"><input name="especialidad" class="form-control form-control-sm" placeholder="Especialidad"></div>
                <div class="col-md-2"><input name="tipo_ejecucion" class="form-control form-control-sm" placeholder="Tipo ejecución"></div>
                <div class="col-md-1"><button class="btn btn-sm btn-primary w-100">+</button></div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header">Presupuesto Base (CUS06 / CUS07)</div>
        <div class="card-body">
            @if($proyecto->presupuestoBase)
                <p><strong>Código:</strong> {{ $proyecto->presupuestoBase->codigo }} —
                   <strong>Monto total:</strong> {{ number_format($proyecto->presupuestoBase->monto_total_presupuestado, 2) }}</p>
                <table class="table table-sm">
                    <thead><tr><th>Código</th><th>Nombre</th><th>Tipo</th><th>Fase</th><th>Presupuestado</th><th>Costo real</th><th>Sustento</th></tr></thead>
                    <tbody>
                    @foreach($proyecto->presupuestoBase->partidasPresupuestales as $partida)
                        <tr>
                            <td>{{ $partida->codigo }}</td>
                            <td>{{ $partida->nombre }}</td>
                            <td><span class="badge bg-{{ $partida->tipo === 'Extraordinaria' ? 'warning' : 'secondary' }}">{{ $partida->tipo }}</span></td>
                            <td>{{ $partida->planFase?->nombre ?? '—' }}</td>
                            <td>{{ number_format($partida->monto_presupuestado, 2) }}</td>
                            <td>{{ number_format($partida->costoRealAcumulado(), 2) }}</td>
                            <td>
                                <form method="POST" action="{{ route('proyectos.costos.store', [$proyecto, $partida]) }}" enctype="multipart/form-data" class="d-flex gap-1">
                                    @csrf
                                    <input type="number" step="0.01" name="monto_neto" placeholder="Monto" class="form-control form-control-sm" style="width:90px" required>
                                    <input type="date" name="fecha_registro" class="form-control form-control-sm" required>
                                    <input type="hidden" name="tipo_moneda" value="{{ $proyecto->tipo_moneda }}">
                                    <input type="hidden" name="tipo_cambio" value="1">
                                    <input type="file" name="documento" class="form-control form-control-sm" required>
                                    <button class="btn btn-sm btn-outline-primary">Registrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <form method="POST" action="{{ route('proyectos.presupuesto.store', $proyecto) }}">
                    @csrf
                    <div class="row g-2 mb-2">
                        <div class="col-md-4"><input name="codigo" class="form-control form-control-sm" placeholder="Código presupuesto" required></div>
                        <div class="col-md-5"><input name="descripcion" class="form-control form-control-sm" placeholder="Descripción"></div>
                        <div class="col-md-3"><input type="date" name="fecha_aprobacion" class="form-control form-control-sm" required></div>
                    </div>
                    <div class="row g-2 mb-1">
                        <div class="col-md-3"><input name="partidas[0][codigo]" class="form-control form-control-sm" placeholder="Cód. partida" required></div>
                        <div class="col-md-4"><input name="partidas[0][nombre]" class="form-control form-control-sm" placeholder="Nombre partida" required></div>
                        <div class="col-md-3"><input name="partidas[0][categoria_costo]" class="form-control form-control-sm" placeholder="Categoría"></div>
                        <div class="col-md-2"><input type="number" step="0.01" name="partidas[0][monto_presupuestado]" class="form-control form-control-sm" placeholder="Monto" required></div>
                    </div>
                    <small class="text-muted">Agrega más partidas incrementando el índice <code>partidas[1]</code>, <code>partidas[2]</code>, etc.</small><br>
                    <button class="btn btn-sm btn-primary mt-2">Registrar presupuesto</button>
                </form>
            @endif

            @if($proyecto->presupuestoBase)
                <form method="POST" action="{{ route('proyectos.partidas.extraordinaria', $proyecto) }}" class="row g-2 mt-3 border-top pt-3">
                    @csrf
                    <div class="col-md-2"><input name="codigo" class="form-control form-control-sm" placeholder="Código" required></div>
                    <div class="col-md-4"><input name="nombre" class="form-control form-control-sm" placeholder="Nombre" required></div>
                    <div class="col-md-3"><input name="categoria_costo" class="form-control form-control-sm" placeholder="Categoría"></div>
                    <div class="col-md-2"><input type="number" step="0.01" name="monto_presupuestado" class="form-control form-control-sm" placeholder="Monto" required></div>
                    <div class="col-md-1"><button class="btn btn-sm btn-warning w-100" title="CUS12 - Partida Extraordinaria">+</button></div>
                </form>
            @endif
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-header">Resultados Mensuales, Alertas y Reportes (CUS14-19)</div>
        <div class="card-body">
            <form method="POST" action="{{ route('proyectos.resultado.generarMensual', $proyecto) }}" class="row g-2 mb-3">
                @csrf
                <div class="col-md-3"><input type="month" name="periodo" class="form-control form-control-sm" required></div>
                <div class="col-md-3"><input type="number" step="0.01" name="avance_fisico" class="form-control form-control-sm" placeholder="% avance físico"></div>
                <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Generar mensual</button></div>
            </form>

            @foreach($proyecto->resultadosOperativosMensuales as $mensual)
                <div class="border rounded p-2 mb-2">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $mensual->periodo }}</strong>
                        <span>Utilidad: {{ number_format($mensual->utilidad, 2) }} — Margen: {{ number_format($mensual->margen * 100, 2) }}%</span>
                    </div>

                    @foreach($mensual->alertas as $alerta)
                        <div class="alert alert-{{ $alerta->estado === 'Activa' ? 'danger' : 'success' }} py-1 px-2 my-1">
                            {{ $alerta->mensaje }} — {{ $alerta->estado }}
                            @if($alerta->estado === 'Activa')
                                <form method="POST" action="{{ route('proyectos.alertas.planAccion', [$proyecto, $alerta]) }}" class="d-flex gap-1 mt-1">
                                    @csrf
                                    <input name="descripcion" class="form-control form-control-sm" placeholder="Descripción del plan de acción" required>
                                    <input name="responsable" class="form-control form-control-sm" placeholder="Responsable" required>
                                    <input type="date" name="fecha_compromiso" class="form-control form-control-sm" required>
                                    <button class="btn btn-sm btn-outline-dark">Registrar plan</button>
                                </form>
                            @endif
                        </div>
                    @endforeach

                    <form method="POST" action="{{ route('proyectos.resultado.comentar', [$proyecto, $mensual]) }}" class="d-flex gap-1 mt-1">
                        @csrf
                        <input name="descripcion" class="form-control form-control-sm" placeholder="Comentario / análisis del período" required>
                        <button class="btn btn-sm btn-outline-secondary">Comentar</button>
                    </form>

                    <form method="POST" action="{{ route('proyectos.reporte.generar', [$proyecto, $mensual]) }}" class="mt-1">
                        @csrf
                        <button class="btn btn-sm btn-outline-primary">Generar reporte mensual</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
