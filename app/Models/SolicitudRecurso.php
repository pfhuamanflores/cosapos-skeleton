<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudRecurso extends Model
{
    protected $table = 'solicitudes_recursos';

    protected $fillable = [
        'plan_fase_id', 'descripcion', 'cantidad', 'unidad_medida', 'fecha_requerida',
        'estado', 'solicitante_id', 'responsable_resolucion_id', 'fecha_resolucion', 'observacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_requerida' => 'date',
            'fecha_resolucion' => 'date',
        ];
    }

    public function planFase(): BelongsTo
    {
        return $this->belongsTo(PlanFase::class);
    }

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'solicitante_id');
    }

    public function responsableResolucion(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'responsable_resolucion_id');
    }
}
