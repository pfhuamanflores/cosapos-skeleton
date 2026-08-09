<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function index(): View
    {
        $proyectos = Proyecto::query()
            ->when(request('buscar'), fn ($query, $buscar) => $query
                ->where(fn ($q) => $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('codigo', 'like', "%{$buscar}%")
                    ->orWhere('cliente', 'like', "%{$buscar}%")))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('portal.index', compact('proyectos'));
    }

    public function show(Proyecto $proyecto): View
    {
        return view('portal.show', compact('proyecto'));
    }
}
