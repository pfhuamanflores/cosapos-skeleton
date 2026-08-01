<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComentarioResultado extends Model
{
    protected $table = 'comentarios_resultado';

    protected $fillable = ['resultado_operativo_mensual_id', 'descripcion', 'usuario_id', 'fecha_registro'];

    protected function casts(): array
    {
        return ['fecha_registro' => 'date'];
    }

    public function resultadoOperativoMensual(): BelongsTo
    {
        return $this->belongsTo(ResultadoOperativoMensual::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}
