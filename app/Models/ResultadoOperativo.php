<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultadoOperativo extends Model
{
    protected $table = 'resultados_operativos';

    protected $fillable = ['proyecto_id', 'venta', 'costo_total', 'utilidad', 'margen'];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }
}
