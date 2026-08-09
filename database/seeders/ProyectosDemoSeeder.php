<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Proyecto;
use App\Models\ResultadoOperativoMensual;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class ProyectosDemoSeeder extends Seeder
{
    public function run(): void
    {
        $creador = Usuario::where('correo', 'admin@cosapos.com')->firstOrFail();

        $proyectos = [
            ['COS-001', 'Ampliación de Planta Industrial Callao', 'Industrias del Pacífico', 'Callao', 'EPC', '2026-01-15', '2027-06-30', 'USD', 'Plantas Industriales', 8500000, 6800000],
            ['COS-002', 'Mejoramiento Vial Panamericana Sur', 'Concesionaria Vial del Sur', 'Ica', 'Precios Unitarios', '2026-02-10', '2027-02-28', 'PEN', 'Infraestructura', 22500000, 18900000],
            ['COS-003', 'Centro Empresarial San Isidro', 'Inversiones Urbanas', 'Lima', 'Suma Alzada', '2026-03-01', '2027-09-30', 'USD', 'Edificaciones', 12800000, 10100000],
            ['COS-004', 'Sistema de Agua Potable Norte', 'Municipalidad Provincial', 'Piura', 'Precios Unitarios', '2026-01-20', '2026-12-20', 'PEN', 'Infraestructura', 18700000, 15400000],
            ['COS-005', 'Modernización de Planta Minera', 'Minería Andina', 'Arequipa', 'EPC', '2026-04-05', '2027-11-30', 'USD', 'Plantas Industriales', 31000000, 24700000],
            ['COS-006', 'Hospital Regional de Alta Complejidad', 'Gobierno Regional', 'La Libertad', 'Suma Alzada', '2026-05-12', '2028-01-31', 'PEN', 'Edificaciones', 48000000, 40500000],
            ['COS-007', 'Puente Vehicular Río Mantaro', 'Provías Nacional', 'Junín', 'Precios Unitarios', '2026-03-18', '2027-05-31', 'PEN', 'Infraestructura', 27600000, 22900000],
            ['COS-008', 'Planta de Tratamiento de Efluentes', 'Agroindustrial del Norte', 'Lambayeque', 'EPC', '2026-06-01', '2027-04-30', 'USD', 'Plantas Industriales', 9600000, 7750000],
            ['COS-009', 'Condominio Residencial Los Jardines', 'Desarrolladora Horizonte', 'Lima', 'Suma Alzada', '2026-02-25', '2027-08-31', 'PEN', 'Edificaciones', 35200000, 29400000],
            ['COS-010', 'Terminal Logístico Portuario', 'Operadora Portuaria Nacional', 'Callao', 'Administración Delegada', '2026-07-10', '2028-03-31', 'USD', 'Infraestructura', 42000000, 34500000],
        ];

        foreach ($proyectos as [$codigo, $nombre, $cliente, $ubicacion, $contrato, $inicio, $termino, $moneda, $unidad, $venta, $costo]) {
            $proyecto = Proyecto::updateOrCreate(['codigo' => $codigo], [
                'nombre' => $nombre,
                'cliente' => $cliente,
                'ubicacion' => $ubicacion,
                'tipo_contrato' => $contrato,
                'fecha_inicio' => $inicio,
                'fecha_termino' => $termino,
                'tipo_moneda' => $moneda,
                'unidad_negocio' => $unidad,
                'creado_por' => $creador->id,
            ]);

            $utilidad = $venta - $costo;
            $proyecto->resultadoOperativo()->updateOrCreate([], [
                'venta' => $venta,
                'costo_total' => $costo,
                'utilidad' => $utilidad,
                'margen' => round($utilidad / $venta, 3),
            ]);
        }

        $proyectoConAlerta = Proyecto::where('codigo', 'COS-005')->firstOrFail();
        $proyectoConAlerta->planFases()->updateOrCreate(
            ['nombre' => 'Ejecución de obras civiles'],
            ['area' => 'Construcción', 'especialidad' => 'Obras civiles', 'tipo_ejecucion' => 'Directa']
        );
        $mensual = ResultadoOperativoMensual::updateOrCreate(
            ['proyecto_id' => $proyectoConAlerta->id, 'periodo' => '2026-07'],
            [
                'costo_total_acumulado' => 27500000,
                'avance_fisico' => 0.620,
                'utilidad' => 3500000,
                'margen' => 0.113,
            ]
        );

        Alerta::updateOrCreate(
            ['resultado_operativo_mensual_id' => $mensual->id, 'tipo' => 'Desviacion de rentabilidad'],
            [
                'mensaje' => 'El margen proyectado (11.30%) es inferior al margen base (20.30%).',
                'nivel' => 'Alta',
                'fecha' => '2026-08-08',
                'estado' => 'Activa',
            ]
        );
    }
}
