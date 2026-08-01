@extends('layouts.app')
@section('titulo', 'Consolidado Corporativo')
@section('contenido')
    <h1 class="h4 mb-3">Consolidado Corporativo de Resultados Operativos (CUS21 / CUS22)</h1>

    @if(auth()->user()->tieneRol(\App\Models\Rol::CONSOLIDADOR_CORPORATIVO, \App\Models\Rol::ADMIN_SISTEMA))
        <form method="POST" action="{{ route('consolidados.store') }}" class="row g-2 mb-4">
            @csrf
            <div class="col-md-3"><input type="month" name="periodo" class="form-control form-control-sm" required></div>
            <div class="col-md-2"><button class="btn btn-sm btn-primary w-100">Generar consolidado</button></div>
        </form>
    @endif

    <table class="table table-striped">
        <thead><tr><th>Período</th><th>Venta total</th><th>Utilidad total</th><th>Margen corporativo</th><th>Generado por</th><th></th></tr></thead>
        <tbody>
        @forelse($consolidados as $c)
            <tr>
                <td>{{ $c->periodo }}</td>
                <td>{{ number_format($c->venta_total, 2) }}</td>
                <td>{{ number_format($c->utilidad_total, 2) }}</td>
                <td>{{ number_format($c->margen_corporativo * 100, 2) }}%</td>
                <td>{{ $c->generadoPor->nombre }}</td>
                <td><a href="{{ route('consolidados.show', $c) }}" class="btn btn-sm btn-outline-primary">Ver detalle</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-muted">Sin consolidados generados.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $consolidados->links() }}
@endsection
