<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoSustento extends Model
{
    protected $table = 'documentos_sustento';

    protected $fillable = ['costo_real_id', 'nombre_archivo', 'ruta_archivo', 'fecha_carga'];

    protected function casts(): array
    {
        return ['fecha_carga' => 'date'];
    }

    public function costoReal(): BelongsTo
    {
        return $this->belongsTo(CostoReal::class);
    }
}
