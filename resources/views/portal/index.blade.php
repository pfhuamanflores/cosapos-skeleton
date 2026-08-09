@extends('layouts.app')
@section('titulo', 'Proyectos')
@section('contenido')
<div class="py-4 text-center">
    <h1>Proyectos de ingeniería y construcción</h1>
    <p class="lead text-muted">Explora los proyectos registrados en COSAPOS S.A.</p>
</div>
<form method="GET" class="input-group mb-4 mx-auto" style="max-width: 720px">
    <input name="buscar" value="{{ request('buscar') }}" class="form-control" placeholder="Buscar por nombre, código o cliente">
    <button class="btn btn-primary">Buscar</button>
</form>
<div class="row g-4">
    @forelse($proyectos as $proyecto)
        <div class="col-md-6 col-lg-4">
            <article class="card h-100 shadow-sm">
                @if($proyecto->imagen)
                    <img src="{{ Storage::url($proyecto->imagen) }}" class="card-img-top" alt="{{ $proyecto->nombre }}" style="height: 210px; object-fit: cover">
                @endif
                <div class="card-body">
                    <span class="badge text-bg-secondary mb-2">{{ $proyecto->codigo }}</span>
                    <h2 class="h5">{{ $proyecto->nombre }}</h2>
                    <p class="text-muted">{{ $proyecto->cliente }} · {{ $proyecto->ubicacion ?: 'Ubicación por definir' }}</p>
                    <a href="{{ route('portal.show', $proyecto) }}" class="btn btn-outline-primary">Ver detalle</a>
                </div>
            </article>
        </div>
    @empty
        <p class="text-center text-muted">No se encontraron proyectos.</p>
    @endforelse
</div>
<div class="mt-4">{{ $proyectos->links() }}</div>
@endsection
