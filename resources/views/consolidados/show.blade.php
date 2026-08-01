@extends('layouts.app')
@section('titulo', 'Consolidado '.$consolidado->periodo)
@section('contenido')
    <h1 class="h4 mb-3">Consolidado Corporativo — {{ $consolidado->periodo }} (CUS22)</h1>

    <div class="row text-center mb-4">
        <div class="col"><strong>Venta total:</strong><br>{{ number_format($consolidado->venta_total, 2) }}</div>
        <div class="col"><strong>Utilidad total:</strong><br>{{ number_format($consolidado->utilidad_total, 2) }}</div>
        <div class="col"><strong>Margen corporativo:</strong><br>{{ number_format($consolidado->margen_corporativo * 100, 2) }}%</div>
    </div>

    <table class="table table-striped">
        <thead><tr><th>Proyecto</th><th>Cliente</th><th>Utilidad del mes</th><th>Margen del mes</th></tr></thead>
        <tbody>
        @foreach($consolidado->resultadosOperativosMensuales as $m)
            <tr>
                <td>{{ $m->proyecto->nombre }}</td>
                <td>{{ $m->proyecto->cliente }}</td>
                <td>{{ number_format($m->utilidad, 2) }}</td>
                <td>{{ number_format($m->margen * 100, 2) }}%</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('consolidados.index') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
@endsection
