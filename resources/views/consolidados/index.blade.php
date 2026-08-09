@extends('layouts.app')
@section('titulo', 'Consolidado Corporativo')
@section('contenido')
    <x-page-header eyebrow="Operación" title="Reportes consolidados" description="Visión corporativa de resultados operativos por periodo." />

    <section class="surface-card p-4 mb-4">

    @if(auth()->user()->tieneRol(\App\Models\Rol::CONSOLIDADOR_CORPORATIVO, \App\Models\Rol::ADMIN_SISTEMA))
        <form method="POST" action="{{ route('consolidados.store') }}" class="row g-2">
            @csrf
            <div class="col-md-3"><input type="month" name="periodo" class="form-control form-control-sm" required></div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Generar consolidado</button></div>
        </form>
    @endif
    </section>

    <section class="surface-card"><div class="table-responsive mobile-cards"><table class="table">
        <thead><tr><th>Período</th><th>Venta total</th><th>Utilidad total</th><th>Margen corporativo</th><th>Generado por</th><th></th></tr></thead>
        <tbody>
        @forelse($consolidados as $c)
            <tr>
                <td data-label="Periodo"><span class="project-code">{{ $c->periodo }}</span></td>
                <td data-label="Venta total">{{ number_format($c->venta_total, 2) }}</td>
                <td data-label="Utilidad">{{ number_format($c->utilidad_total, 2) }}</td>
                <td data-label="Margen"><span class="badge bg-success-subtle text-success">{{ number_format($c->margen_corporativo * 100, 2) }}%</span></td>
                <td data-label="Generado por">{{ $c->generadoPor->nombre }}</td>
                <td data-label="Acciones"><a href="{{ route('consolidados.show', $c) }}" class="btn btn-sm btn-outline-primary">Ver detalle</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted">Sin consolidados generados.</td></tr>
        @endforelse
        </tbody>
    </table></div><div class="surface-pagination">{{ $consolidados->links() }}</div></section>
@endsection
