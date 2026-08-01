<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [Rol::ADMIN_SISTEMA, 'Gestiona usuarios y asigna roles de acceso.'],
            [Rol::ESPECIALISTA_PRESUPUESTOS, 'Registra proyectos y presupuestos base.'],
            [Rol::INGENIERO_COSTOS, 'Registra fases, partidas, costos reales y resultados operativos.'],
            [Rol::ADMIN_PROYECTO, 'Administra solicitudes de recursos del proyecto.'],
            [Rol::SOLICITANTE_RECURSOS, 'Registra solicitudes de recursos para la ejecución.'],
            [Rol::GERENTE_PROYECTO, 'Aprueba solicitudes de recursos, alertas e informes mensuales.'],
            [Rol::CONSOLIDADOR_CORPORATIVO, 'Genera el consolidado corporativo de resultados.'],
            [Rol::MONITOR_CORPORATIVO, 'Supervisa de forma pasiva el consolidado corporativo.'],
        ];

        foreach ($roles as [$nombre, $descripcion]) {
            Rol::updateOrCreate(['nombre' => $nombre], ['descripcion' => $descripcion]);
        }
    }
}
