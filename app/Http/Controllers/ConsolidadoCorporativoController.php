<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsolidadoCorporativoRequest;
use App\Models\ConsolidadoCorporativo;
use App\Models\ResultadoOperativoMensual;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * CUS21 - Generar Consolidado Corporativo de Resultados Operativos.
 * CI Crear Consolidado / CI Lista Consolidados -> CC Consolidados Corporativos
 *   -> CP Resultado Operativo Mensual, CP Consolidado Corporativo -> ConsolidadoCorporativo
 *
 * CUS22 - Consultar Consolidado Corporativo.
 * CI Consolidado / CI Lista Consolidados -> CC Consolidados Corporativos -> CP Consolidado Corporativo
 */
class ConsolidadoCorporativoController extends Controller
{
    public function index(): View
    {
        $consolidados = ConsolidadoCorporativo::with('generadoPor')->latest('periodo')->paginate(12);

        return view('consolidados.index', compact('consolidados'));
    }

    public function store(ConsolidadoCorporativoRequest $request): RedirectResponse
    {
        $mensuales = ResultadoOperativoMensual::where('periodo', $request->periodo)->get();

        abort_if($mensuales->isEmpty(), 422, 'No existen resultados operativos mensuales para el período indicado.');

        DB::transaction(function () use ($mensuales, $request) {
            $ventaTotal = $mensuales->sum(fn ($m) => (float) optional($m->proyecto)->ventaContractual?->monto_contrato);
            $utilidadTotal = $mensuales->sum('utilidad');
            $margen = $ventaTotal > 0 ? round($utilidadTotal / $ventaTotal, 4) : 0;

            $consolidado = ConsolidadoCorporativo::create([
                'periodo' => $request->periodo,
                'venta_total' => $ventaTotal,
                'utilidad_total' => $utilidadTotal,
                'margen_corporativo' => $margen,
                'generado_por' => Auth::id(),
                'fecha_generacion' => now(),
            ]);

            $consolidado->resultadosOperativosMensuales()->attach($mensuales->pluck('id'));
        });

        return redirect()->route('consolidados.index')->with('exito', 'Consolidado corporativo generado correctamente.');
    }

    public function show(ConsolidadoCorporativo $consolidado): View
    {
        $consolidado->load('resultadosOperativosMensuales.proyecto');

        return view('consolidados.show', compact('consolidado'));
    }
}
