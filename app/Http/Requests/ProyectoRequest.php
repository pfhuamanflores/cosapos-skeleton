<?php

namespace App\Http\Requests;

use App\Models\Rol;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProyectoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tieneRol(Rol::ESPECIALISTA_PRESUPUESTOS, Rol::ADMIN_SISTEMA);
    }

    public function rules(): array
    {
        $proyectoId = $this->route('proyecto')?->id;

        return [
            'codigo' => ['required', 'string', 'max:30', Rule::unique('proyectos', 'codigo')->ignore($proyectoId)],
            'nombre' => ['required', 'string', 'max:150'],
            'cliente' => ['required', 'string', 'max:150'],
            'ubicacion' => ['nullable', 'string', 'max:150'],
            'tipo_contrato' => ['nullable', 'string', 'max:60'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_termino' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'tipo_moneda' => ['required', 'string', 'max:10'],
            'unidad_negocio' => ['nullable', 'string', 'max:100'],
        ];
    }
}
