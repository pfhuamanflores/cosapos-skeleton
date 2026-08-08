<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'COSAPOS') · COSAPOS S.A.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/cosapos.css') }}">
</head>
<body class="bg-light">
@auth
<nav class="navbar navbar-expand-lg cosapos-navbar">
    <div class="container-fluid">

        <a class="navbar-brand cosapos-brand" href="{{ route('dashboard') }}">
            <div class="cosapos-brand-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="cosapos-brand-text">
                <strong>COSAPOS S.A.</strong>
                <small>Ingeniería & Construcción</small>
            </div>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#nav"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">

            <ul class="navbar-nav me-auto cosapos-nav-menu">

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}"
                    >
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('proyectos.*') ? 'active' : '' }}"
                        href="{{ route('proyectos.index') }}"
                    >
                        Proyectos
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('consolidados.*') ? 'active' : '' }}"
                        href="{{ route('consolidados.index') }}"
                    >
                        Consolidado
                    </a>
                </li>

                @if(auth()->user()->tieneRol(\App\Models\Rol::ADMIN_SISTEMA))
                    <li class="nav-item">
                        <a
                            class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}"
                            href="{{ route('usuarios.index') }}"
                        >
                            Usuarios
                        </a>
                    </li>
                @endif

            </ul>

            <div class="cosapos-user-area">

                <div class="cosapos-user-avatar">
                    {{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}
                </div>

                <div class="cosapos-user-info">
                    <strong>{{ auth()->user()->nombre }}</strong>
                    <small>{{ auth()->user()->rol->nombre }}</small>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="btn cosapos-logout-btn" type="submit">
                        Cerrar sesión
                    </button>
                </form>

            </div>

        </div>
    </div>
</nav>
@endauth

<div class="container my-4">
    @if(session('exito'))
        <div class="alert alert-success">{{ session('exito') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('contenido')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
