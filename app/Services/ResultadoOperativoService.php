<?php

namespace App\Services;

use App\Models\Alerta;
use App\Models\Proyecto;
use App\Models\ResultadoOperativo;
use App\Models\ResultadoOperativoMensual;

/**
 * Encapsula las reglas de negocio de CUS08, CUS13, CUS14 y CUS15,
 * evitando duplicar cálculos de margen/utilidad en los controladores.
 */
class ResultadoOperativoService
{
    public function generarBase(Proyecto $proyecto): ResultadoOperativo
    {
        $venta = (float) optional($proyecto->ventaContractual)->monto_contrato;
        $costoTotal = (float) $proyecto->presupuestoBase?->monto_total_presupuestado;
        $utilidad = $venta - $costoTotal;
        $margen = $venta > 0 ? round($utilidad / $venta, 4) : 0;

        return $proyecto->resultadoOperativo()->updateOrCreate([], [
            'venta' => $venta,
            'costo_total' => $costoTotal,
            'utilidad' => $utilidad,
            'margen' => $margen,
        ]);
    }

    public function generarMensual(Proyecto $proyecto, string $periodo, ?float $avanceFisico): ResultadoOperativoMensual
    {
        $costoTotalAcumulado = (float) $proyecto->presupuestoBase?->partidasPresupuestales()
            ->with('costosReales')
            ->get()
            ->sum(fn ($partida) => $partida->costoRealAcumulado());

        $venta = (float) optional($proyecto->ventaContractual)->monto_contrato;
        $utilidad = $venta - $costoTotalAcumulado;
        $margen = $venta > 0 ? round($utilidad / $venta, 4) : 0;

        $mensual = $proyecto->resultadosOperativosMensuales()->create([
            'periodo' => $periodo,
            'costo_total_acumulado' => $costoTotalAcumulado,
            'avance_fisico' => $avanceFisico,
            'utilidad' => $utilidad,
            'margen' => $margen,
        ]);

        $this->evaluarDesviacion($proyecto, $mensual);

        return $mensual;
    }

    /**
     * CUS15 - Alertar Desviación de Rentabilidad.
     * Se dispara automáticamente cada vez que se genera un resultado operativo mensual.
     */
    protected function evaluarDesviacion(Proyecto $proyecto, ResultadoOperativoMensual $mensual): void
    {
        $margenBase = (float) optional($proyecto->resultadoOperativo)->margen;

        if ($mensual->margen < $margenBase) {
            $mensual->alertas()->create([
                'tipo' => 'Desviacion de rentabilidad',
                'mensaje' => sprintf(
                    'El margen proyectado (%.2f%%) es inferior al margen base (%.2f%%).',
                    $mensual->margen * 100,
                    $margenBase * 100
                ),
                'nivel' => 'Alta',
                'fecha' => now()->toDateString(),
                'estado' => 'Activa',
            ]);
        }
    }
}
