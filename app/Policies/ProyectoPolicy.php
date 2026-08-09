<?php

namespace App\Policies;

use App\Models\Proyecto;
use App\Models\Rol;
use App\Models\Usuario;

class ProyectoPolicy
{
    public function create(Usuario $usuario): bool
    {
        return $usuario->tieneRol(Rol::ADMIN_SISTEMA);
    }

    public function update(Usuario $usuario, Proyecto $proyecto): bool
    {
        return $usuario->tieneRol(Rol::ADMIN_SISTEMA);
    }

    public function delete(Usuario $usuario, Proyecto $proyecto): bool
    {
        return $usuario->tieneRol(Rol::ADMIN_SISTEMA);
    }
}
