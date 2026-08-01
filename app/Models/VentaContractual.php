<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VentaContractual extends Model
{
    protected $table = 'ventas_contractuales';

    protected $fillable = ['proyecto_id', 'monto_contrato', 'fecha_firma', 'estado_contrato'];

    protected function casts(): array
    {
        return ['fecha_firma' => 'date'];
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }
}
