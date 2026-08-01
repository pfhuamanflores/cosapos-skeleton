@extends('layouts.app')
@section('titulo', 'Solicitudes de Recursos')
@section('contenido')
    <h1 class="h4 mb-3">Solicitudes de Recursos — {{ $proyecto->nombre }} (CUS09 / CUS10)</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fase</th><th>Descripción</th><th>Cantidad</th><th>Solicitante</th>
                <th>Fecha requerida</th><th>Estado</th><th>Resolver</th>
            </tr>
        </thead>
        <tbody>
        @forelse($solicitudes as $s)
            <tr>
                <td>{{ $s->planFase->nombre }}</td>
                <td>{{ $s->descripcion }}</td>
                <td>{{ $s->cantidad }} {{ $s->unidad_medida }}</td>
                <td>{{ $s->solicitante->nombre }} {{ $s->solicitante->apellido }}</td>
                <td>{{ $s->fecha_requerida->format('d/m/Y') }}</td>
                <td>
                    <span class="badge bg-{{ match($s->estado) {
                        'Aprobada' => 'success', 'Rechazada' => 'danger', 'Observada' => 'warning', default => 'secondary'
                    } }}">{{ $s->estado }}</span>
                </td>
                <td>
                    @if($s->estado === 'Pendiente')
                        <form method="POST" action="{{ route('proyectos.solicitudes.resolver', [$proyecto, $s]) }}" class="d-flex gap-1">
                            @csrf @method('PUT')
                            <select name="estado" class="form-select form-select-sm" style="width:120px">
                                <option value="Aprobada">Aprobar</option>
                                <option value="Observada">Observar</option>
                                <option value="Rechazada">Rechazar</option>
                            </select>
                            <input name="observacion" class="form-control form-control-sm" placeholder="Observación">
                            <button class="btn btn-sm btn-primary">Guardar</button>
                        </form>
                    @else
                        <small class="text-muted">{{ $s->fecha_resolucion?->format('d/m/Y') }}</small>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-muted">Sin solicitudes registradas.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $solicitudes->links() }}

    <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-outline-secondary btn-sm">Volver al proyecto</a>

    <hr>
    <h2 class="h6">Nueva solicitud</h2>
    <form method="POST" action="{{ route('proyectos.solicitudes.store', [$proyecto, request('fase_id', $proyecto->planFases->first()->id ?? 0)]) }}" class="row g-2">
        @csrf
        <div class="col-md-4"><input name="descripcion" class="form-control form-control-sm" placeholder="Descripción del recurso" required></div>
        <div class="col-md-2"><input type="number" step="0.01" name="cantidad" class="form-control form-control-sm" placeholder="Cantidad" required></div>
        <div class="col-md-2"><input name="unidad_medida" class="form-control form-control-sm" placeholder="Unidad"></div>
        <div class="col-md-2"><input type="date" name="fecha_requerida" class="form-control form-control-sm" required></div>
        <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Registrar</button></div>
    </form>
@endsection
