@extends('layouts.app')
@section('titulo', 'Resumen — '.$proyecto->nombre)
@section('contenido')
    <h1 class="h4 mb-3">Resumen de Resultado Operativo — {{ $proyecto->nombre }} (CUS20)</h1>
    <p class="text-muted">Nivel de detalle según su rol: <strong>{{ $detalleCompleto ? 'Completo' : 'Resumido' }}</strong></p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Período</th>
                <th>Margen</th>
                <th>Utilidad</th>
                @if($detalleCompleto)<th>Costo total acumulado</th><th>Avance físico</th>@endif
            </tr>
        </thead>
        <tbody>
        @forelse($mensuales as $m)
            <tr>
                <td>{{ $m->periodo }}</td>
                <td>{{ number_format($m->margen * 100, 2) }}%</td>
                <td>{{ number_format($m->utilidad, 2) }}</td>
                @if($detalleCompleto)
                    <td>{{ number_format($m->costo_total_acumulado, 2) }}</td>
                    <td>{{ $m->avance_fisico ? number_format($m->avance_fisico, 2).'%' : '—' }}</td>
                @endif
            </tr>
        @empty
            <tr><td colspan="5" class="text-muted">Aún no hay resultados operativos mensuales.</td></tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-outline-secondary btn-sm">Volver al proyecto</a>
@endsection
