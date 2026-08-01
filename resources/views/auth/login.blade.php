@extends('layouts.app')
@section('titulo', 'Iniciar sesión')
@section('contenido')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-3 text-center">COSAPOS S.A.</h4>
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo corporativo</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" name="recordar" class="form-check-input" id="recordar">
                        <label class="form-check-label" for="recordar">Recordarme</label>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
