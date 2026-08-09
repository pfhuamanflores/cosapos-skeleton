<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyectoRequest;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * CUS04 - Registrar Proyecto.
 * CI Listado Proyectos / CI Crear Proyecto -> CC Proyectos -> CP Proyecto -> Proyecto
 */
class ProyectoController extends Controller
{
    public function index(): View
    {
        $proyectos = Proyecto::with(['resultadoOperativo', 'creador', 'resultadosOperativosMensuales' => fn ($q) => $q->latest('periodo')])
            ->when(request('buscar'), fn ($q) => $q->where('nombre', 'like', '%'.request('buscar').'%')
                ->orWhere('codigo', 'like', '%'.request('buscar').'%'))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('proyectos.index', compact('proyectos'));
    }

    public function create(): View
    {
        return view('proyectos.create');
    }

    public function store(ProyectoRequest $request): RedirectResponse
    {
        $datos = $request->validated();
        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('proyectos', 'public');
        }
        $proyecto = Proyecto::create($datos + ['creado_por' => Auth::id()]);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Proyecto registrado correctamente.');
    }

    public function show(Proyecto $proyecto): View
    {
        $proyecto->load([
            'ventaContractual', 'planFases', 'presupuestoBase.partidasPresupuestales',
            'resultadoOperativo', 'resultadosOperativosMensuales' => fn ($q) => $q->latest('periodo'),
        ]);

        return view('proyectos.show', compact('proyecto'));
    }

    public function edit(Proyecto $proyecto): View
    {
        return view('proyectos.edit', compact('proyecto'));
    }

    public function update(ProyectoRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $datos = $request->validated();
        if ($request->hasFile('imagen')) {
            if ($proyecto->imagen) {
                Storage::disk('public')->delete($proyecto->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('proyectos', 'public');
        }
        $proyecto->update($datos);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Proyecto $proyecto): RedirectResponse
    {
        $this->authorize('delete', $proyecto);

        if ($proyecto->imagen) {
            Storage::disk('public')->delete($proyecto->imagen);
        }
        $proyecto->delete();

        return redirect()->route('proyectos.index')->with('exito', 'Proyecto eliminado correctamente.');
    }
}
