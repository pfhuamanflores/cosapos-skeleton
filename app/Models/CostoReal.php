<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostoReal extends Model
{
    protected $table = 'costos_reales';

    protected $fillable = [
        'partida_presupuestal_id', 'monto_neto', 'fecha_registro',
        'tipo_moneda', 'tipo_cambio', 'registrado_por',
    ];

    protected function casts(): array
    {
        return ['fecha_registro' => 'date'];
    }

    public function partidaPresupuestal(): BelongsTo
    {
        return $this->belongsTo(PartidaPresupuestal::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'registrado_por');
    }

    public function documentosSustento(): HasMany
    {
        return $this->hasMany(DocumentoSustento::class);
    }
}
