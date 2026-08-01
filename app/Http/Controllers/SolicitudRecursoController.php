<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResolverSolicitudRequest;
use App\Http\Requests\SolicitudRecursoRequest;
use App\Models\PlanFase;
use App\Models\Proyecto;
use App\Models\SolicitudRecurso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * CUS09 - Registrar Solicitud de Recursos.
 * CI Crear Solicitud de Recursos -> CC Solicitudes Recursos -> CP Solicitud Recurso / CP Plan Fases
 *
 * CUS10 - Aprobar Solicitud de Recursos.
 * CI Solicitud de Recursos / CI Lista Solicitudes Recursos -> CC Solicitudes Recursos -> CP Solicitud Recurso
 */
class SolicitudRecursoController extends Controller
{
    public function index(Proyecto $proyecto): View
    {
        $solicitudes = SolicitudRecurso::whereHas('planFase', fn ($q) => $q->where('proyecto_id', $proyecto->id))
            ->with(['planFase', 'solicitante', 'responsableResolucion'])
            ->latest()
            ->paginate(10);

        return view('solicitudes.index', compact('proyecto', 'solicitudes'));
    }

    public function store(SolicitudRecursoRequest $request, Proyecto $proyecto, PlanFase $fase): RedirectResponse
    {
        $fase->solicitudesRecursos()->create($request->validated() + [
            'solicitante_id' => Auth::id(),
            'estado' => 'Pendiente',
        ]);

        return redirect()->route('proyectos.solicitudes.index', $proyecto)->with('exito', 'Solicitud de recursos registrada correctamente.');
    }

    public function resolver(ResolverSolicitudRequest $request, Proyecto $proyecto, SolicitudRecurso $solicitud): RedirectResponse
    {
        $solicitud->update([
            'estado' => $request->estado,
            'observacion' => $request->observacion,
            'responsable_resolucion_id' => Auth::id(),
            'fecha_resolucion' => now()->toDateString(),
        ]);

        return redirect()->route('proyectos.solicitudes.index', $proyecto)->with('exito', 'Solicitud actualizada correctamente.');
    }
}
