<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanFase extends Model
{
    protected $fillable = ['proyecto_id', 'nombre', 'area', 'especialidad', 'tipo_ejecucion'];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function partidasPresupuestales(): HasMany
    {
        return $this->hasMany(PartidaPresupuestal::class);
    }

    public function solicitudesRecursos(): HasMany
    {
        return $this->hasMany(SolicitudRecurso::class);
    }
}
