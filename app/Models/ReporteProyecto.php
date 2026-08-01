<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteProyecto extends Model
{
    protected $table = 'reportes_proyecto';

    protected $fillable = [
        'proyecto_id', 'resultado_operativo_mensual_id', 'periodo', 'fecha_generacion',
        'estado', 'generado_por', 'aprobado_por',
    ];

    protected function casts(): array
    {
        return ['fecha_generacion' => 'datetime'];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function resultadoOperativoMensual(): BelongsTo
    {
        return $this->belongsTo(ResultadoOperativoMensual::class);
    }

    public function generadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'generado_por');
    }

    public function aprobadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'aprobado_por');
    }
}
