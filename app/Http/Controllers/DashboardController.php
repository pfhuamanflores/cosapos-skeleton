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
        $proyectosRecientes = Proyecto::with('resultadoOperativo')->latest()->take(5)->get();

        return view('dashboard', compact('totalProyectos', 'alertasActivas', 'solicitudesPendientes', 'proyectosRecientes'));
    }
}
