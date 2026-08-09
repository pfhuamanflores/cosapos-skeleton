<?php

namespace Tests\Feature;

use App\Models\Proyecto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EliminarProyectoTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrador_puede_eliminar_un_proyecto(): void
    {
        [$administrador, $proyecto] = $this->crearUsuarioYProyecto(Rol::ADMIN_SISTEMA);

        $this->actingAs($administrador)
            ->delete(route('proyectos.destroy', $proyecto))
            ->assertRedirect(route('proyectos.index'))
            ->assertSessionHas('exito', 'Proyecto eliminado correctamente.');

        $this->assertDatabaseMissing('proyectos', ['id' => $proyecto->id]);
    }

    public function test_usuario_sin_rol_administrador_no_puede_eliminar_un_proyecto(): void
    {
        [$usuario, $proyecto] = $this->crearUsuarioYProyecto(Rol::GERENTE_PROYECTO);

        $this->actingAs($usuario)
            ->delete(route('proyectos.destroy', $proyecto))
            ->assertForbidden();

        $this->assertDatabaseHas('proyectos', ['id' => $proyecto->id]);
    }

    private function crearUsuarioYProyecto(string $nombreRol): array
    {
        $rol = Rol::create(['nombre' => $nombreRol]);
        $usuario = Usuario::create([
            'nombre' => 'Usuario',
            'apellido' => 'Prueba',
            'correo' => uniqid().'@example.com',
            'password' => 'password',
            'rol_id' => $rol->id,
        ]);
        $proyecto = Proyecto::create([
            'codigo' => uniqid('PR-'),
            'nombre' => 'Proyecto de prueba',
            'cliente' => 'Cliente de prueba',
            'fecha_inicio' => '2026-08-08',
            'creado_por' => $usuario->id,
        ]);

        return [$usuario, $proyecto];
    }
}
