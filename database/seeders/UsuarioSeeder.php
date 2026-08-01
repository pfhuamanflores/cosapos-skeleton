<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $adminRol = Rol::where('nombre', Rol::ADMIN_SISTEMA)->firstOrFail();

        Usuario::updateOrCreate(
            ['correo' => 'admin@cosapos.com'],
            [
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'password' => Hash::make('password'),
                'activo' => true,
                'rol_id' => $adminRol->id,
            ]
        );
    }
}
