<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaContractualRequest;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;

/**
 * Registro de la Venta Contractual del proyecto.
 * Entidad requerida por CUS08 - Generar Resultado Operativo Base del Proyecto.
 */
class VentaContractualController extends Controller
{
    public function store(VentaContractualRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $proyecto->ventaContractual()->updateOrCreate([], $request->validated());

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Venta contractual registrada correctamente.');
    }
}
