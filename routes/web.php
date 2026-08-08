<?php

use App\Http\Controllers\AutenticacionController;
use App\Http\Controllers\ConsolidadoCorporativoController;
use App\Http\Controllers\CostoRealController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanFaseController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ResultadoOperativoController;
use App\Http\Controllers\ResumenResultadoController;
use App\Http\Controllers\ReporteProyectoController;
use App\Http\Controllers\SolicitudRecursoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaContractualController;
use Illuminate\Support\Facades\Route;

// CUS01 - Autenticar Usuario
Route::middleware('guest')->group(function () {
    Route::get('/login', [AutenticacionController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AutenticacionController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AutenticacionController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // CUS02-03 - Gestionar Usuarios / Asignar Rol
    Route::resource('usuarios', UsuarioController::class)->except(['show']);

    // CUS04 - Registrar Proyecto
    Route::resource('proyectos', ProyectoController::class)->except(['destroy']);

    // CUS05 - Registrar Plan de Fases del Proyecto
    Route::post('proyectos/{proyecto}/fases', [PlanFaseController::class, 'store'])->name('proyectos.fases.store');
    Route::put('proyectos/{proyecto}/fases/{fase}', [PlanFaseController::class, 'update'])->name('proyectos.fases.update');
    Route::delete('proyectos/{proyecto}/fases/{fase}', [PlanFaseController::class, 'destroy'])->name('proyectos.fases.destroy');

    Route::post('proyectos/{proyecto}/venta-contractual', [VentaContractualController::class, 'store'])->name('proyectos.venta.store');

    // CUS06 - Registrar Presupuesto Base / CUS07 - Asociar Partidas a Fases
    Route::post('proyectos/{proyecto}/presupuesto', [PresupuestoController::class, 'store'])->name('proyectos.presupuesto.store');
    Route::put('proyectos/{proyecto}/partidas/{partida}/fase', [PresupuestoController::class, 'asociarFase'])->name('proyectos.partidas.asociarFase');

    // CUS11 - Registrar Costo Real / CUS12 - Registrar Partida Extraordinaria
    Route::post('proyectos/{proyecto}/partidas/{partida}/costos', [CostoRealController::class, 'store'])->name('proyectos.costos.store');
    Route::post('proyectos/{proyecto}/partidas-extraordinarias', [CostoRealController::class, 'storeExtraordinaria'])->name('proyectos.partidas.extraordinaria');
    Route::get('proyectos/{proyecto}/partidas/{partida}/documentos/{documento}', [CostoRealController::class, 'descargarSustento'])->name('proyectos.documentos.descargar');

    // CUS09-10 - Solicitudes de Recursos
    Route::get('proyectos/{proyecto}/solicitudes', [SolicitudRecursoController::class, 'index'])->name('proyectos.solicitudes.index');
    Route::post('proyectos/{proyecto}/fases/{fase}/solicitudes', [SolicitudRecursoController::class, 'store'])->name('proyectos.solicitudes.store');
    Route::put('proyectos/{proyecto}/solicitudes/{solicitud}', [SolicitudRecursoController::class, 'resolver'])->name('proyectos.solicitudes.resolver');

    // CUS08,13 - Resultado Operativo Base
    Route::post('proyectos/{proyecto}/resultado-base', [ResultadoOperativoController::class, 'generarBase'])->name('proyectos.resultado.generarBase');
    Route::put('proyectos/{proyecto}/resultado-base', [ResultadoOperativoController::class, 'actualizarBase'])->name('proyectos.resultado.actualizarBase');

    // CUS14 - Resultado Operativo Mensual (dispara CUS15 Alerta internamente)
    Route::post('proyectos/{proyecto}/resultado-mensual', [ResultadoOperativoController::class, 'generarMensual'])->name('proyectos.resultado.generarMensual');

    // CUS17 - Comentarios del Resultado Operativo
    Route::post('proyectos/{proyecto}/resultado-mensual/{mensual}/comentarios', [ResultadoOperativoController::class, 'comentar'])->name('proyectos.resultado.comentar');

    // CUS16 - Plan de Acción por Desviación
    Route::post('proyectos/{proyecto}/alertas/{alerta}/plan-accion', [ResultadoOperativoController::class, 'registrarPlanAccion'])->name('proyectos.alertas.planAccion');

    // CUS18-19 - Reporte Mensual del Proyecto
    Route::post('proyectos/{proyecto}/resultado-mensual/{mensual}/reporte', [ReporteProyectoController::class, 'generar'])->name('proyectos.reporte.generar');
    Route::put('proyectos/{proyecto}/reportes/{reporte}', [ReporteProyectoController::class, 'aprobar'])->name('proyectos.reporte.aprobar');

    // CUS20 - Consultar Resumen de Resultado Operativo
    Route::get('proyectos/{proyecto}/resumen', [ResumenResultadoController::class, 'show'])->name('proyectos.resumen');

    // CUS21-22 - Consolidado Corporativo
    Route::get('consolidados', [ConsolidadoCorporativoController::class, 'index'])->name('consolidados.index');
    Route::post('consolidados', [ConsolidadoCorporativoController::class, 'store'])->name('consolidados.store');
    Route::get('consolidados/{consolidado}', [ConsolidadoCorporativoController::class, 'show'])->name('consolidados.show');
});
