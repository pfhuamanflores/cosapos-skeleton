<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Proyecto extends Model
{
    protected $fillable = [
        'codigo', 'nombre', 'cliente', 'ubicacion', 'tipo_contrato',
        'fecha_inicio', 'fecha_termino', 'tipo_moneda', 'unidad_negocio', 'creado_por',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_termino' => 'date',
        ];
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    public function ventaContractual(): HasOne
    {
        return $this->hasOne(VentaContractual::class);
    }

    public function planFases(): HasMany
    {
        return $this->hasMany(PlanFase::class);
    }

    public function presupuestoBase(): HasOne
    {
        return $this->hasOne(PresupuestoBase::class);
    }

    public function resultadoOperativo(): HasOne
    {
        return $this->hasOne(ResultadoOperativo::class);
    }

    public function resultadosOperativosMensuales(): HasMany
    {
        return $this->hasMany(ResultadoOperativoMensual::class);
    }

    public function reportesProyecto(): HasMany
    {
        return $this->hasMany(ReporteProyecto::class);
    }

    public function solicitudesRecursos(): HasManyThrough
    {
        return $this->hasManyThrough(SolicitudRecurso::class, PlanFase::class);
    }
}
