<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresupuestoBaseRequest;
use App\Models\PartidaPresupuestal;
use App\Models\PlanFase;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * CUS06 - Registrar Presupuesto Base del Proyecto.
 * CI Crear Presupuesto Base / CI Proyecto -> CC Presupuestos -> CP Presupuesto Base / CP Partida Presupuestal
 *
 * CUS07 - Asociar Partidas Presupuestales a Fases.
 * CI Proyecto -> CC Presupuestos -> CP Partida Presupuestal / CP Plan Fases -> PartidaPresupuestal / PlanFase
 */
class PresupuestoController extends Controller
{
    public function store(PresupuestoBaseRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $datos = $request->validated();

        DB::transaction(function () use ($proyecto, $datos) {
            $montoTotal = collect($datos['partidas'])->sum('monto_presupuestado');

            $presupuesto = $proyecto->presupuestoBase()->create([
                'codigo' => $datos['codigo'],
                'descripcion' => $datos['descripcion'] ?? null,
                'monto_total_presupuestado' => $montoTotal,
                'fecha_aprobacion' => $datos['fecha_aprobacion'],
            ]);

            foreach ($datos['partidas'] as $partida) {
                $presupuesto->partidasPresupuestales()->create([
                    'codigo' => $partida['codigo'],
                    'nombre' => $partida['nombre'],
                    'categoria_costo' => $partida['categoria_costo'] ?? null,
                    'monto_presupuestado' => $partida['monto_presupuestado'],
                    'plan_fase_id' => $partida['plan_fase_id'] ?? null,
                    'tipo' => 'Normal',
                ]);
            }
        });

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Presupuesto base registrado correctamente.');
    }

    /**
     * CUS07 - asocia (o reasigna) una partida existente a una fase del proyecto.
     */
    public function asociarFase(Request $request, Proyecto $proyecto, PartidaPresupuestal $partida): RedirectResponse
    {
        $request->validate([
            'plan_fase_id' => ['required', 'exists:plan_fases,id'],
        ]);

        $fase = PlanFase::where('proyecto_id', $proyecto->id)->findOrFail($request->plan_fase_id);
        $partida->update(['plan_fase_id' => $fase->id]);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Partida asociada a la fase correctamente.');
    }
}
