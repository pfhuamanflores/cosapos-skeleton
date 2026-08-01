<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResultadoOperativoMensual extends Model
{
    protected $table = 'resultados_operativos_mensuales';

    protected $fillable = [
        'proyecto_id', 'periodo', 'costo_total_acumulado', 'avance_fisico', 'utilidad', 'margen',
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function comentariosResultado(): HasMany
    {
        return $this->hasMany(ComentarioResultado::class);
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(Alerta::class);
    }

    public function reporteProyecto(): HasMany
    {
        return $this->hasMany(ReporteProyecto::class);
    }
}
