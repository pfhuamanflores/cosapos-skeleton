<?php

namespace App\Policies;

use App\Models\Rol;
use App\Models\Usuario;

class UsuarioPolicy
{
    public function viewAny(Usuario $actor): bool
    {
        return $actor->tieneRol(Rol::ADMIN_SISTEMA);
    }

    public function create(Usuario $actor): bool
    {
        return $actor->tieneRol(Rol::ADMIN_SISTEMA);
    }

    public function update(Usuario $actor, Usuario $usuario): bool
    {
        return $actor->tieneRol(Rol::ADMIN_SISTEMA);
    }

    public function delete(Usuario $actor, Usuario $usuario): bool
    {
        return $actor->tieneRol(Rol::ADMIN_SISTEMA) && $actor->id !== $usuario->id;
    }
}
