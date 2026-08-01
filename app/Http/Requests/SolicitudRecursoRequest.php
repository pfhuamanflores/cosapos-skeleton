<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudRecursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'numeric', 'min:0.01'],
            'unidad_medida' => ['nullable', 'string', 'max:30'],
            'fecha_requerida' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
