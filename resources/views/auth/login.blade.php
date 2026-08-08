@extends('layouts.app')

@section('titulo', 'Iniciar sesión')

@section('contenido')

<div class="login-shell">

    <div class="login-brand-side">

        <div class="login-brand-content">

            <div class="brand-mark">
                <div class="brand-symbol">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <div>
                    <h1>COSAPOS S.A.</h1>
                    <p>Ingeniería & Construcción</p>
                </div>
            </div>

            <div class="brand-copy">
                <span class="brand-kicker">Gestión integral de proyectos</span>

                <h2>
                    Ingeniería, planificación y control en una sola plataforma.
                </h2>

                <p>
                    Administra proyectos, presupuestos, costos,
                    resultados operativos y alertas desde un entorno
                    centralizado y confiable.
                </p>
            </div>

            <div class="brand-features">

                <div class="brand-feature">
                    <div class="feature-icon">01</div>
                    <div>
                        <strong>Control de proyectos</strong>
                        <span>Seguimiento integral de la ejecución.</span>
                    </div>
                </div>

                <div class="brand-feature">
                    <div class="feature-icon">02</div>
                    <div>
                        <strong>Gestión financiera</strong>
                        <span>Presupuesto, costos y resultados.</span>
                    </div>
                </div>

                <div class="brand-feature">
                    <div class="feature-icon">03</div>
                    <div>
                        <strong>Información oportuna</strong>
                        <span>Indicadores para la toma de decisiones.</span>
                    </div>
                </div>

            </div>

        </div>

        <div class="engineering-grid"></div>

    </div>


    <div class="login-form-side">

        <div class="login-form-wrapper">

            <div class="login-mobile-brand">
                COSAPOS S.A.
            </div>

            <span class="login-overline">Acceso corporativo</span>

            <h2 class="login-title">
                Bienvenido
            </h2>

            <p class="login-description">
                Ingresa tus credenciales para acceder al sistema.
            </p>


            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif


            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="mb-4">

                    <label for="correo" class="form-label">
                        Correo corporativo
                    </label>

                    <div class="cosapos-input">

                        <div class="input-icon">
                            @
                        </div>

                        <input
                            id="correo"
                            type="email"
                            name="correo"
                            class="form-control"
                            value="{{ old('correo') }}"
                            placeholder="usuario@cosapos.com"
                            required
                            autofocus
                        >

                    </div>

                </div>


                <div class="mb-3">

                    <label for="password" class="form-label">
                        Contraseña
                    </label>

                    <div class="cosapos-input">

                        <div class="input-icon">
                            ●
                        </div>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Ingresa tu contraseña"
                            required
                        >

                    </div>

                </div>


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div class="form-check">

                        <input
                            type="checkbox"
                            name="recordar"
                            class="form-check-input"
                            id="recordar"
                        >

                        <label
                            class="form-check-label"
                            for="recordar"
                        >
                            Recordarme
                        </label>

                    </div>

                </div>


                <button
                    class="btn btn-cosapos btn-login w-100"
                    type="submit"
                >
                    Ingresar al sistema
                </button>

            </form>


            <div class="login-footer">
                <span>Sistema de Gestión de Proyectos</span>
                <span>•</span>
                <span>COSAPOS S.A.</span>
            </div>

        </div>

    </div>

</div>

@endsection
