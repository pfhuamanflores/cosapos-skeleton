<?php

namespace Tests\Feature;

use App\Models\Proyecto;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LineamientosGeneralesTest extends TestCase
{
    use RefreshDatabase;

    public function test_portal_y_detalle_de_proyecto_son_publicos(): void
    {
        $proyecto = $this->crearProyecto();

        $this->get(route('portal.index'))->assertOk()->assertSee($proyecto->nombre);
        $this->get(route('portal.show', $proyecto))->assertOk()->assertSee($proyecto->cliente);
    }

    public function test_visitante_puede_registrarse_como_solicitante(): void
    {
        Rol::create(['nombre' => Rol::SOLICITANTE_RECURSOS]);

        $this->post(route('registro.store'), [
            'nombre' => 'Paula', 'apellido' => 'Pérez', 'correo' => 'paula@example.com',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect(route('portal.index'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('usuarios', ['correo' => 'paula@example.com']);
    }

    public function test_dashboard_y_crud_son_exclusivos_del_administrador(): void
    {
        $usuario = $this->crearUsuario(Rol::SOLICITANTE_RECURSOS, 'usuario@example.com');
        $proyecto = $this->crearProyecto();

        $this->actingAs($usuario)->get(route('dashboard'))->assertForbidden();
        $this->get(route('proyectos.create'))->assertForbidden();
        $this->get(route('proyectos.edit', $proyecto))->assertForbidden();
        $this->delete(route('proyectos.destroy', $proyecto))->assertForbidden();
    }

    public function test_administrador_puede_crear_proyecto_con_imagen(): void
    {
        Storage::fake('public');
        $administrador = $this->crearUsuario(Rol::ADMIN_SISTEMA, 'admin@example.com');
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');

        $respuesta = $this->actingAs($administrador)->post(route('proyectos.store'), [
            'codigo' => 'PR-IMG', 'nombre' => 'Proyecto con imagen', 'cliente' => 'Cliente',
            'fecha_inicio' => '2026-08-08', 'tipo_moneda' => 'PEN',
            'imagen' => UploadedFile::fake()->createWithContent('proyecto.png', $png),
        ]);

        $proyecto = Proyecto::where('codigo', 'PR-IMG')->firstOrFail();
        $respuesta->assertRedirect(route('proyectos.show', $proyecto));
        Storage::disk('public')->assertExists($proyecto->imagen);
    }

    private function crearUsuario(string $rolNombre, string $correo): Usuario
    {
        $rol = Rol::firstOrCreate(['nombre' => $rolNombre]);

        return Usuario::create([
            'nombre' => 'Usuario', 'apellido' => 'Prueba', 'correo' => $correo,
            'password' => 'password123', 'rol_id' => $rol->id,
        ]);
    }

    private function crearProyecto(): Proyecto
    {
        $creador = Usuario::where('correo', 'creador@example.com')->first()
            ?? $this->crearUsuario(Rol::ADMIN_SISTEMA, 'creador@example.com');

        return Proyecto::create([
            'codigo' => uniqid('PR-'), 'nombre' => 'Proyecto público',
            'cliente' => 'Cliente público', 'fecha_inicio' => '2026-08-08',
            'creado_por' => $creador->id,
        ]);
    }
}
