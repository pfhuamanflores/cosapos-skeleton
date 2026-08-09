@extends('layouts.app')
@section('titulo', $proyecto->nombre)
@section('contenido')
<a href="{{ route('portal.index') }}" class="btn btn-link ps-0 mb-3">← Volver a proyectos</a>
<article class="card shadow-sm overflow-hidden">
    @if($proyecto->imagen)
        <img src="{{ Storage::url($proyecto->imagen) }}" alt="{{ $proyecto->nombre }}" style="max-height: 420px; object-fit: cover">
    @endif
    <div class="card-body p-4">
        <span class="badge text-bg-secondary">{{ $proyecto->codigo }}</span>
        <h1 class="mt-2">{{ $proyecto->nombre }}</h1>
        <dl class="row mt-4">
            <dt class="col-sm-3">Cliente</dt><dd class="col-sm-9">{{ $proyecto->cliente }}</dd>
            <dt class="col-sm-3">Ubicación</dt><dd class="col-sm-9">{{ $proyecto->ubicacion ?: 'Por definir' }}</dd>
            <dt class="col-sm-3">Tipo de contrato</dt><dd class="col-sm-9">{{ $proyecto->tipo_contrato ?: 'Por definir' }}</dd>
            <dt class="col-sm-3">Fecha de inicio</dt><dd class="col-sm-9">{{ $proyecto->fecha_inicio->format('d/m/Y') }}</dd>
            <dt class="col-sm-3">Unidad de negocio</dt><dd class="col-sm-9">{{ $proyecto->unidad_negocio ?: 'Por definir' }}</dd>
        </dl>
        @auth
            <a href="{{ route('proyectos.solicitudes.index', $proyecto) }}" class="btn btn-primary">Enviar solicitud de recurso</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Inicia sesión para enviar una solicitud</a>
        @endauth
    </div>
</article>
@endsection
