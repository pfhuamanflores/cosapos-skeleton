<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $table = 'roles';

    protected $fillable = ['nombre', 'descripcion'];

    // Roles definidos por el diagrama de clases de análisis (CUS01-CUS03, CUS21-CUS22)
    public const ADMIN_SISTEMA = 'Administrador del Sistema';
    public const ESPECIALISTA_PRESUPUESTOS = 'Especialista de Presupuestos';
    public const INGENIERO_COSTOS = 'Ingeniero de Costos';
    public const ADMIN_PROYECTO = 'Administrador de Proyecto';
    public const SOLICITANTE_RECURSOS = 'Solicitante de Recursos';
    public const GERENTE_PROYECTO = 'Gerente de Proyecto';
    public const CONSOLIDADOR_CORPORATIVO = 'Consolidador Corporativo';
    public const MONITOR_CORPORATIVO = 'Monitor Corporativo';

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class);
    }
}
