@extends('layouts.app')
@section('titulo', 'Crear cuenta')
@section('contenido')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4 mb-3">Crear cuenta</h1>
                <form method="POST" action="{{ route('registro.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Nombre</label><input name="nombre" value="{{ old('nombre') }}" class="form-control" required></div>
                        <div class="col-md-6"><label class="form-label">Apellido</label><input name="apellido" value="{{ old('apellido') }}" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Correo</label><input type="email" name="correo" value="{{ old('correo') }}" class="form-control" required></div>
                        <div class="col-12"><label class="form-label">Contraseña</label><input type="password" name="password" class="form-control" minlength="8" required></div>
                        <div class="col-12"><label class="form-label">Confirmar contraseña</label><input type="password" name="password_confirmation" class="form-control" required></div>
                    </div>
                    <button class="btn btn-primary w-100 mt-4">Registrarme</button>
                </form>
                <p class="text-center mt-3 mb-0"><a href="{{ route('login') }}">Ya tengo una cuenta</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
