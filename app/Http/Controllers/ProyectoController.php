<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyectoRequest;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * CUS04 - Registrar Proyecto.
 * CI Listado Proyectos / CI Crear Proyecto -> CC Proyectos -> CP Proyecto -> Proyecto
 */
class ProyectoController extends Controller
{
    public function index(): View
    {
        $proyectos = Proyecto::with(['resultadoOperativo', 'creador'])
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
        $proyecto = Proyecto::create($request->validated() + ['creado_por' => Auth::id()]);

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
        $proyecto->update($request->validated());

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Proyecto actualizado correctamente.');
    }
}
