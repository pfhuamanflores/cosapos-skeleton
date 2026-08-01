<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanAccion extends Model
{
    protected $table = 'planes_accion';

    protected $fillable = ['alerta_id', 'descripcion', 'responsable', 'fecha_compromiso', 'registrado_por'];

    protected function casts(): array
    {
        return ['fecha_compromiso' => 'date'];
    }

    public function alerta(): BelongsTo
    {
        return $this->belongsTo(Alerta::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }
}
