<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComentarioResultadoRequest;
use App\Http\Requests\PlanAccionRequest;
use App\Http\Requests\ResultadoOperativoMensualRequest;
use App\Models\Alerta;
use App\Models\Proyecto;
use App\Models\ResultadoOperativoMensual;
use App\Services\ResultadoOperativoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ResultadoOperativoController extends Controller
{
    public function __construct(protected ResultadoOperativoService $servicio)
    {
    }

    /**
     * CUS08 - Generar Resultado Operativo Base del Proyecto.
     */
    public function generarBase(Proyecto $proyecto): RedirectResponse
    {
        abort_unless($proyecto->presupuestoBase && $proyecto->ventaContractual, 422,
            'El proyecto requiere venta contractual y presupuesto base antes de generar el resultado operativo.');

        $this->servicio->generarBase($proyecto);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Resultado operativo base generado correctamente.');
    }

    /**
     * CUS13 - Actualizar Resultado Operativo del Proyecto (recalcula la base con datos vigentes).
     */
    public function actualizarBase(Proyecto $proyecto): RedirectResponse
    {
        $this->servicio->generarBase($proyecto);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Resultado operativo actualizado correctamente.');
    }

    /**
     * CUS14 - Generar Resultado Operativo Mensual del Proyecto (dispara CUS15 internamente).
     */
    public function generarMensual(ResultadoOperativoMensualRequest $request, Proyecto $proyecto): RedirectResponse
    {
        $this->servicio->generarMensual($proyecto, $request->periodo, $request->avance_fisico);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Resultado operativo mensual generado correctamente.');
    }

    /**
     * CUS17 - Registrar Análisis y Comentarios del Resultado Operativo.
     */
    public function comentar(ComentarioResultadoRequest $request, Proyecto $proyecto, ResultadoOperativoMensual $mensual): RedirectResponse
    {
        $mensual->comentariosResultado()->create([
            'descripcion' => $request->descripcion,
            'usuario_id' => Auth::id(),
            'fecha_registro' => now()->toDateString(),
        ]);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Comentario registrado correctamente.');
    }

    /**
     * CUS16 - Registrar Plan de Acción por Desviación (desactiva la alerta relacionada).
     */
    public function registrarPlanAccion(PlanAccionRequest $request, Proyecto $proyecto, Alerta $alerta): RedirectResponse
    {
        $alerta->planesAccion()->create($request->validated() + ['registrado_por' => Auth::id()]);
        $alerta->update(['estado' => 'Atendida']);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Plan de acción registrado y alerta atendida.');
    }
}
