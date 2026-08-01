<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alerta extends Model
{
    protected $fillable = ['resultado_operativo_mensual_id', 'tipo', 'mensaje', 'nivel', 'fecha', 'estado'];

    protected function casts(): array
    {
        return ['fecha' => 'date'];
    }

    public function resultadoOperativoMensual(): BelongsTo
    {
        return $this->belongsTo(ResultadoOperativoMensual::class);
    }

    public function planesAccion(): HasMany
    {
        return $this->hasMany(PlanAccion::class);
    }
}
