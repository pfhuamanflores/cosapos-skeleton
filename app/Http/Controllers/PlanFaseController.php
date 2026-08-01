<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanFaseRequest;
use App\Models\PlanFase;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;

/**
 * CUS05 - Registrar Plan de Fases del Proyecto.
 * CI Plan de Fases -> CC Proyectos -> CP Fase -> PlanFase
 */
class PlanFaseController extends Controller
{
    public function store(PlanFaseRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $proyecto->planFases()->create($request->validated());

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Fase registrada correctamente.');
    }

    public function update(PlanFaseRequest $request, Proyecto $proyecto, PlanFase $fase): RedirectResponse
    {
        $fase->update($request->validated());

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Fase actualizada correctamente.');
    }

    public function destroy(Proyecto $proyecto, PlanFase $fase): RedirectResponse
    {
        $fase->delete();

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Fase eliminada correctamente.');
    }
}
