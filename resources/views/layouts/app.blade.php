<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'COSAPOS') · COSAPOS S.A.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/cosapos.css') }}">
</head>
<body>
@guest
    <nav class="navbar navbar-expand-lg cosapos-navbar">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="{{ route('portal.index') }}">COSAPOS S.A.</a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light" href="{{ route('login') }}">Iniciar sesión</a>
                <a class="btn btn-light" href="{{ route('registro') }}">Crear cuenta</a>
            </div>
        </div>
    </nav>
    <main class="container my-4">
        @include('partials.messages')
        @yield('contenido')
    </main>
@endguest

@auth
<div class="app-shell">
    <aside class="app-sidebar" id="appSidebar" aria-label="Navegación principal">
        <div class="sidebar-brand">
            <a href="{{ auth()->user()->tieneRol(\App\Models\Rol::ADMIN_SISTEMA) ? route('dashboard') : route('portal.index') }}" class="cosapos-brand">
                <div class="cosapos-brand-icon" aria-hidden="true"><span></span><span></span><span></span></div>
                <div class="cosapos-brand-text"><strong>COSAPOS S.A.</strong><small>Ingeniería & Construcción</small></div>
            </a>
            <button class="sidebar-close d-lg-none" type="button" data-sidebar-close aria-label="Cerrar navegación"><i class="bi bi-x-lg"></i></button>
        </div>

        <nav class="sidebar-nav">
            @if(auth()->user()->tieneRol(\App\Models\Rol::ADMIN_SISTEMA))
                <a class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2"></i><span>Dashboard</span></a>
            @endif
            <div class="sidebar-label">Gestión</div>
            <a class="sidebar-link {{ request()->routeIs('proyectos.*') ? 'active' : '' }}" href="{{ route('proyectos.index') }}"><i class="bi bi-kanban"></i><span>Proyectos</span></a>
            <a class="sidebar-link {{ request()->routeIs('portal.*') ? 'active' : '' }}" href="{{ route('portal.index') }}"><i class="bi bi-building"></i><span>Portal público</span></a>

            <div class="sidebar-label">Operación</div>
            <a class="sidebar-link {{ request()->routeIs('consolidados.*') ? 'active' : '' }}" href="{{ route('consolidados.index') }}"><i class="bi bi-bar-chart-line"></i><span>Reportes consolidados</span></a>

            @if(auth()->user()->tieneRol(\App\Models\Rol::ADMIN_SISTEMA))
                <div class="sidebar-label">Configuración</div>
                <a class="sidebar-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}"><i class="bi bi-people"></i><span>Usuarios y roles</span></a>
            @endif
        </nav>

        <div class="sidebar-user">
            <div class="cosapos-user-avatar">{{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}</div>
            <div class="sidebar-user-copy"><strong>{{ auth()->user()->nombre }} {{ auth()->user()->apellido }}</strong><small>{{ auth()->user()->rol->nombre }}</small></div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button class="sidebar-logout" type="submit" aria-label="Cerrar sesión" title="Cerrar sesión"><i class="bi bi-box-arrow-right"></i></button></form>
        </div>
    </aside>

    <div class="sidebar-backdrop" data-sidebar-close></div>
    <div class="app-main">
        <header class="app-topbar">
            <button class="topbar-menu d-lg-none" type="button" data-sidebar-open aria-label="Abrir navegación"><i class="bi bi-list"></i></button>
            <div class="topbar-context"><span>Workspace</span><strong>@yield('titulo', 'COSAPOS')</strong></div>
            <div class="topbar-actions">
                <form action="{{ route('proyectos.index') }}" method="GET" class="global-search d-none d-md-flex">
                    <i class="bi bi-search"></i><input name="buscar" aria-label="Buscar proyectos" placeholder="Buscar proyectos…">
                </form>
                <button class="topbar-icon" type="button" aria-label="Notificaciones"><i class="bi bi-bell"></i>@if(\App\Models\Alerta::where('estado', 'Activa')->exists())<span></span>@endif</button>
                <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->nombre, 0, 1)) }}</div>
            </div>
        </header>
        <main class="app-content">
            @include('partials.messages')
            @yield('contenido')
        </main>
    </div>
</div>
@endauth

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelector('[data-sidebar-open]')?.addEventListener('click', () => document.body.classList.add('sidebar-open'));
document.querySelectorAll('[data-sidebar-close]').forEach(el => el.addEventListener('click', () => document.body.classList.remove('sidebar-open')));
</script>
</body>
</html>
