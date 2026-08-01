<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartidaExtraordinariaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:30'],
            'nombre' => ['required', 'string', 'max:150'],
            'categoria_costo' => ['nullable', 'string', 'max:80'],
            'monto_presupuestado' => ['required', 'numeric', 'min:0'],
            'justificacion' => ['required', 'string', 'max:500'],
        ];
    }
}
