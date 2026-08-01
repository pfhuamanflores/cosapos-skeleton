<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ConsolidadoCorporativo extends Model
{
    protected $table = 'consolidados_corporativos';

    protected $fillable = [
        'periodo', 'venta_total', 'utilidad_total', 'margen_corporativo', 'generado_por', 'fecha_generacion',
    ];

    protected function casts(): array
    {
        return ['fecha_generacion' => 'datetime'];
    }

    public function generadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'generado_por');
    }

    public function resultadosOperativosMensuales(): BelongsToMany
    {
        return $this->belongsToMany(
            ResultadoOperativoMensual::class,
            'consolidado_resultado'
        );
    }
}
