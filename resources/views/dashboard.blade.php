@extends('layouts.app')
@section('titulo', 'Dashboard')
@section('contenido')
<h3 class="mb-4">Panel de control</h3>
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card text-bg-primary"><div class="card-body">
            <h6>Proyectos registrados</h6><h2>{{ $totalProyectos }}</h2>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-danger"><div class="card-body">
            <h6>Alertas activas</h6><h2>{{ $alertasActivas }}</h2>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-warning"><div class="card-body">
            <h6>Solicitudes pendientes</h6><h2>{{ $solicitudesPendientes }}</h2>
        </div></div>
    </div>
</div>

<h5>Proyectos recientes</h5>
<table class="table table-striped bg-white">
    <thead><tr><th>Código</th><th>Nombre</th><th>Cliente</th><th>Margen base</th><th></th></tr></thead>
    <tbody>
    @foreach($proyectosRecientes as $proyecto)
        <tr>
            <td>{{ $proyecto->codigo }}</td>
            <td>{{ $proyecto->nombre }}</td>
            <td>{{ $proyecto->cliente }}</td>
            <td>{{ $proyecto->resultadoOperativo ? number_format($proyecto->resultadoOperativo->margen * 100, 1).'%' : '—' }}</td>
            <td><a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-sm btn-outline-primary">Ver</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
