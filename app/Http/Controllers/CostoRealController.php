<?php

namespace App\Http\Controllers;

use App\Http\Requests\CostoRealRequest;
use App\Http\Requests\PartidaExtraordinariaRequest;
use App\Models\PartidaPresupuestal;
use App\Models\Proyecto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * CUS11 - Registrar Costo Real del Proyecto.
 * CI Registrar Costo Real / CI Partida Presupuestal -> CC Presupuestos
 *   -> CP Partida Presupuestal, CP Costo Real, CP Documento Sustento
 *   -> Partida Presupuestal, Costo Real, Documento Sustento
 *
 * CUS12 - Registrar Partida Extraordinaria.
 * CI Proyecto / CI Crear Partida Extraordinaria -> CC Presupuestos -> CP Partida Presupuestal -> Partida Presupuestal
 */
class CostoRealController extends Controller
{
    public function store(CostoRealRequest $request, Proyecto $proyecto, PartidaPresupuestal $partida): RedirectResponse
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos, $partida, $request) {
            $costoReal = $partida->costosReales()->create([
                'monto_neto' => $datos['monto_neto'],
                'fecha_registro' => $datos['fecha_registro'],
                'tipo_moneda' => $datos['tipo_moneda'],
                'tipo_cambio' => $datos['tipo_cambio'],
                'registrado_por' => Auth::id(),
            ]);

            $ruta = $request->file('documento')->store('sustentos', 'local');

            $costoReal->documentosSustento()->create([
                'nombre_archivo' => $request->file('documento')->getClientOriginalName(),
                'ruta_archivo' => $ruta,
                'fecha_carga' => now()->toDateString(),
            ]);
        });

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Costo real registrado y sustentado correctamente.');
    }

    public function storeExtraordinaria(PartidaExtraordinariaRequest $request, Proyecto $proyecto): RedirectResponse
    {
        // Solo procede si no existe una partida presupuestal previa para ese código dentro del proyecto,
        // condición del caso de uso "cuando un costo pertenece al proyecto pero no existe partida asociada".
        $presupuesto = $proyecto->presupuestoBase;

        abort_if(! $presupuesto, 422, 'El proyecto no cuenta con presupuesto base registrado.');

        $presupuesto->partidasPresupuestales()->create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'categoria_costo' => $request->categoria_costo,
            'monto_presupuestado' => $request->monto_presupuestado,
            'tipo' => 'Extraordinaria',
        ]);

        return redirect()->route('proyectos.show', $proyecto)->with('exito', 'Partida extraordinaria registrada correctamente.');
    }

    public function descargarSustento(Proyecto $proyecto, PartidaPresupuestal $partida, int $documentoId)
    {
        $documento = $partida->costosReales()
            ->with('documentosSustento')
            ->get()
            ->pluck('documentosSustento')
            ->flatten()
            ->firstWhere('id', $documentoId);

        abort_unless($documento, 404);

        return Storage::disk('local')->download($documento->ruta_archivo, $documento->nombre_archivo);
    }
}
