<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Proyecto;
use App\Models\SolicitudRecurso;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProyectos = Proyecto::count();
        $alertasActivas = Alerta::where('estado', 'Activa')->count();
        $solicitudesPendientes = SolicitudRecurso::where('estado', 'Pendiente')->count();
        $presupuestoTotal = (float) Proyecto::query()->join('resultados_operativos', 'proyectos.id', '=', 'resultados_operativos.proyecto_id')->sum('resultados_operativos.costo_total');
        $costoEjecutado = (float) Proyecto::query()->join('resultados_operativos_mensuales', 'proyectos.id', '=', 'resultados_operativos_mensuales.proyecto_id')->sum('resultados_operativos_mensuales.costo_total_acumulado');
        $avancePromedio = (float) Proyecto::query()->join('resultados_operativos_mensuales', 'proyectos.id', '=', 'resultados_operativos_mensuales.proyecto_id')->avg('resultados_operativos_mensuales.avance_fisico');
        $proyectosRecientes = Proyecto::with(['resultadoOperativo', 'resultadosOperativosMensuales' => fn ($q) => $q->latest('periodo')])->latest()->take(5)->get();
        $alertas = Alerta::with('resultadoOperativoMensual.proyecto')->where('estado', 'Activa')->latest('fecha')->take(4)->get();

        return view('dashboard', compact('totalProyectos', 'alertasActivas', 'solicitudesPendientes', 'presupuestoTotal', 'costoEjecutado', 'avancePromedio', 'proyectosRecientes', 'alertas'));
    }
}
