<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestoBaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30', 'unique:presupuestos_base,codigo'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'fecha_aprobacion' => ['required', 'date'],
            'partidas' => ['required', 'array', 'min:1'],
            'partidas.*.codigo' => ['required', 'string', 'max:30'],
            'partidas.*.nombre' => ['required', 'string', 'max:150'],
            'partidas.*.categoria_costo' => ['nullable', 'string', 'max:80'],
            'partidas.*.monto_presupuestado' => ['required', 'numeric', 'min:0'],
            'partidas.*.plan_fase_id' => ['nullable', 'exists:plan_fases,id'],
        ];
    }
}
