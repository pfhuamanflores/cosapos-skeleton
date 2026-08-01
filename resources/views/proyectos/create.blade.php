@extends('layouts.app')
@section('titulo', 'Nuevo Proyecto')
@section('contenido')
    <h1 class="h4 mb-4">Registrar Proyecto</h1>
    <form method="POST" action="{{ route('proyectos.store') }}" class="card card-body shadow-sm">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Código</label>
                <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Nombre del proyecto</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cliente</label>
                <input type="text" name="cliente" value="{{ old('cliente') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ubicación</label>
                <input type="text" name="ubicacion" value="{{ old('ubicacion') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tipo de contrato</label>
                <input type="text" name="tipo_contrato" value="{{ old('tipo_contrato') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Fecha de inicio</label>
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fecha de término</label>
                <input type="date" name="fecha_termino" value="{{ old('fecha_termino') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Moneda</label>
                <select name="tipo_moneda" class="form-select">
                    <option value="PEN" selected>Soles (PEN)</option>
                    <option value="USD">Dólares (USD)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Unidad de negocio</label>
                <input type="text" name="unidad_negocio" value="{{ old('unidad_negocio') }}" class="form-control">
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Guardar</button>
            <a href="{{ route('proyectos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
@endsection
