<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PresupuestoBase extends Model
{
    protected $table = 'presupuestos_base';

    protected $fillable = ['proyecto_id', 'codigo', 'descripcion', 'monto_total_presupuestado', 'fecha_aprobacion'];

    protected function casts(): array
    {
        return ['fecha_aprobacion' => 'date'];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function partidasPresupuestales(): HasMany
    {
        return $this->hasMany(PartidaPresupuestal::class);
    }
}
