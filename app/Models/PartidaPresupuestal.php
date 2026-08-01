<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartidaPresupuestal extends Model
{
    protected $table = 'partidas_presupuestales';

    protected $fillable = [
        'presupuesto_base_id', 'plan_fase_id', 'codigo', 'nombre',
        'categoria_costo', 'monto_presupuestado', 'tipo',
    ];

    public function presupuestoBase(): BelongsTo
    {
        return $this->belongsTo(PresupuestoBase::class);
    }

    public function planFase(): BelongsTo
    {
        return $this->belongsTo(PlanFase::class);
    }

    public function costosReales(): HasMany
    {
        return $this->hasMany(CostoReal::class);
    }

    public function costoRealAcumulado(): float
    {
        return (float) $this->costosReales()->sum('monto_neto');
    }
}
