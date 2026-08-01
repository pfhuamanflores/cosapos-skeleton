@extends('layouts.app')
@section('titulo', 'Editar Proyecto')
@section('contenido')
    <h1 class="h4 mb-4">Editar Proyecto — {{ $proyecto->codigo }}</h1>
    <form method="POST" action="{{ route('proyectos.update', $proyecto) }}" class="card card-body shadow-sm">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Código</label>
                <input type="text" name="codigo" value="{{ old('codigo', $proyecto->codigo) }}" class="form-control" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Nombre del proyecto</label>
                <input type="text" name="nombre" value="{{ old('nombre', $proyecto->nombre) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cliente</label>
                <input type="text" name="cliente" value="{{ old('cliente', $proyecto->cliente) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ubicación</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion', $proyecto->ubicacion) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipo de contrato</label>
                <input type="text" name="tipo_contrato" value="{{ old('tipo_contrato', $proyecto->tipo_contrato) }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Fecha de inicio</label>
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $proyecto->fecha_inicio->format('Y-m-d')) }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fecha de término</label>
                <input type="date" name="fecha_termino" value="{{ old('fecha_termino', $proyecto->fecha_termino?->format('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Moneda</label>
                <select name="tipo_moneda" class="form-select">
                    @foreach(['PEN' => 'Soles (PEN)', 'USD' => 'Dólares (USD)'] as $valor => $texto)
                        <option value="{{ $valor }}" @selected(old('tipo_moneda', $proyecto->tipo_moneda) === $valor)>{{ $texto }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Unidad de negocio</label>
                <input type="text" name="unidad_negocio" value="{{ old('unidad_negocio', $proyecto->unidad_negocio) }}" class="form-control">
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Actualizar</button>
            <a href="{{ route('proyectos.show', $proyecto) }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
@endsection
