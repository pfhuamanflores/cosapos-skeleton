@extends('layouts.app')
@section('titulo', 'Usuarios')
@section('contenido')
<x-page-header eyebrow="Configuración" title="Usuarios y roles" description="Gestiona las cuentas, permisos y acceso al sistema."><a href="{{ route('usuarios.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i>Nuevo usuario</a></x-page-header>
<section class="surface-card">
    <div class="project-toolbar"><form method="GET" class="project-search"><i class="bi bi-search"></i><input name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre o correo…"><button class="btn btn-primary">Buscar</button></form><div class="toolbar-meta"><i class="bi bi-people"></i>{{ $usuarios->total() }} usuarios</div></div>
    <div class="table-responsive mobile-cards"><table class="table"><thead><tr><th>Usuario</th><th>Correo</th><th>Rol asignado</th><th>Estado</th><th></th></tr></thead><tbody>
    @foreach($usuarios as $usuario)<tr>
        <td data-label="Usuario"><div class="project-cell"><span class="project-avatar">{{ strtoupper(substr($usuario->nombre,0,1).substr($usuario->apellido,0,1)) }}</span><span><a href="{{ route('usuarios.edit',$usuario) }}">{{ $usuario->nombre }} {{ $usuario->apellido }}</a><small>Creado {{ $usuario->created_at->format('d/m/Y') }}</small></span></div></td>
        <td data-label="Correo">{{ $usuario->correo }}</td><td data-label="Rol"><span class="badge bg-primary-subtle text-primary">{{ $usuario->rol->nombre }}</span></td>
        <td data-label="Estado"><span class="status-pill {{ $usuario->activo ? 'status-active' : 'bg-secondary-subtle text-secondary' }}">@if($usuario->activo)<i></i>@endif{{ $usuario->activo ? 'Activo' : 'Inactivo' }}</span></td>
        <td data-label="Acciones" class="text-end"><a href="{{ route('usuarios.edit',$usuario) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i>Editar</a>@if($usuario->activo)<form method="POST" action="{{ route('usuarios.destroy',$usuario) }}" class="d-inline" onsubmit="return confirm('¿Inactivar este usuario?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-person-x"></i>Inactivar</button></form>@endif</td>
    </tr>@endforeach
    </tbody></table></div><div class="surface-pagination">{{ $usuarios->links() }}</div>
</section>
@endsection
