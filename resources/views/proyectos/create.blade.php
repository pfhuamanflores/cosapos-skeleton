@extends('layouts.app')
@section('titulo', 'Nuevo Proyecto')
@section('contenido')
    <h1 class="h4 mb-4">Registrar Proyecto</h1>
    <form method="POST" action="{{ route('proyectos.store') }}" enctype="multipart/form-data" class="card card-body shadow-sm">
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
                <select name="tipo_contrato" class="form-select" required>
                    <option value="" disabled selected>
                        Seleccione un tipo de contrato
                    </option>
                    <option value="Suma Alzada">Suma Alzada</option>
                    <option value="Precios Unitarios">Precios Unitarios</option>
                    <option value="Administración Delegada">Administración Delegada</option>
                    <option value="EPC">EPC (Ingeniería, Procura y Construcción)</option>
                </select>
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
                <select name="tipo_moneda" class="form-select" required>
                    <option value="" disabled selected>
                        Seleccione una moneda
                    </option>
                    <option value="PEN">
                        Soles (PEN)
                    </option>
                    <option value="USD">
                        Dólares estadounidenses (USD)
                    </option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Unidad de negocio</label>
                <select name="unidad_negocio" class="form-select" required>
                    <option value="" disabled selected>
                        Seleccione una unidad de negocio
                    </option>
                    <option value="Plantas Industriales">
                        Plantas Industriales
                    </option>
                    <option value="Infraestructura">
                        Infraestructura
                    </option>
                    <option value="Edificaciones">
                        Edificaciones
                    </option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Imagen del proyecto</label>
                <input type="file" name="imagen" class="form-control" accept="image/jpeg,image/png,image/webp">
                <div class="form-text">JPG, PNG o WebP; máximo 2 MB.</div>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">Guardar</button>
            <a href="{{ route('proyectos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
@endsection
