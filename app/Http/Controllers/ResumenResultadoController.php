<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Rol;
use Illuminate\View\View;

/**
 * CUS20 - Consultar Resumen de Resultado Operativo del Proyecto.
 * CI Resumen Resultado Operativo -> CC Autenticaciones + CC Resultados Operativos -> CP Rol / CP Resultado Operativo Mensual
 */
class ResumenResultadoController extends Controller
{
    public function show(Proyecto $proyecto): View
    {
        $usuario = auth()->user();

        // El nivel de detalle se adapta al rol autenticado, según el diagrama de CUS20.
        $detalleCompleto = $usuario->tieneRol(
            Rol::GERENTE_PROYECTO,
            Rol::ADMIN_SISTEMA,
            Rol::CONSOLIDADOR_CORPORATIVO,
            Rol::MONITOR_CORPORATIVO
        );

        $mensuales = $proyecto->resultadosOperativosMensuales()
            ->when(! $detalleCompleto, fn ($q) => $q->select('id', 'proyecto_id', 'periodo', 'margen', 'utilidad'))
            ->latest('periodo')
            ->get();

        return view('proyectos.resumen', compact('proyecto', 'mensuales', 'detalleCompleto'));
    }
}
