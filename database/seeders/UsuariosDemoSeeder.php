<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Crea un usuario de prueba por cada rol del sistema, para poder
 * demostrar las diferencias de acceso entre roles.
 * Contraseña para todos: password
 */
class UsuariosDemoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [Rol::ESPECIALISTA_PRESUPUESTOS, 'especialista@cosapos.com', 'Especialista', 'Presupuestos'],
            [Rol::INGENIERO_COSTOS, 'ingeniero@cosapos.com', 'Ingeniero', 'Costos'],
            [Rol::ADMIN_PROYECTO, 'adminproyecto@cosapos.com', 'Admin', 'Proyecto'],
            [Rol::SOLICITANTE_RECURSOS, 'solicitante@cosapos.com', 'Solicitante', 'Recursos'],
            [Rol::GERENTE_PROYECTO, 'gerente@cosapos.com', 'Gerente', 'Proyecto'],
            [Rol::CONSOLIDADOR_CORPORATIVO, 'consolidador@cosapos.com', 'Consolidador', 'Corporativo'],
            [Rol::MONITOR_CORPORATIVO, 'monitor@cosapos.com', 'Monitor', 'Corporativo'],
        ];

        foreach ($usuarios as [$nombreRol, $correo, $nombre, $apellido]) {
            $rol = Rol::where('nombre', $nombreRol)->first();

            if (! $rol) {
                continue;
            }

            Usuario::updateOrCreate(
                ['correo' => $correo],
                [
                    'nombre' => $nombre,
                    'apellido' => $apellido,
                    'password' => Hash::make('password'),
                    'activo' => true,
                    'rol_id' => $rol->id,
                ]
            );
        }
    }
}
