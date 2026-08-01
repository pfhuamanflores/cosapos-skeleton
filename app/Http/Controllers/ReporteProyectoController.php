<?php

namespace App\Http\Controllers;

use App\Http\Requests\AprobarReporteRequest;
use App\Models\Proyecto;
use App\Models\ReporteProyecto;
use App\Models\ResultadoOperativoMensual;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

/**
 * CUS18 - Generar Reporte Mensual del Proyecto.
 * CI Proyecto / CI Crear Reporte Mensual Proyecto -> CC Resultados Operativos + CC Reportes Proyectos
 *   -> CP Resultado Operativo Mensual, CP Comentario Resultado, CP Reporte Proyecto
 *
 * CUS19 - Aprobar Informe Mensual del Proyecto.
 * CI Aprobaciones Informes -> CC Reportes Proyectos -> CP Reporte Proyecto
 */
class ReporteProyectoController extends Controller
{
    public function generar(Proyecto $proyecto, ResultadoOperativoMensual $mensual): RedirectResponse
    {
        $proyecto->reportesProyecto()->create([
            'resultado_operativo_mensual_id' => $mensual->id,
            'periodo' => $mensual->periodo,
            'fecha_generacion' => now(),
            'estado' => 'Generado',
            'generado_por' => Auth::id(),
        ]);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Reporte mensual generado correctamente.');
    }

    public function aprobar(AprobarReporteRequest $request, Proyecto $proyecto, ReporteProyecto $reporte): RedirectResponse
    {
        $reporte->update([
            'estado' => $request->estado,
            'aprobado_por' => Auth::id(),
        ]);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Estado del informe actualizado correctamente.');
    }
}
