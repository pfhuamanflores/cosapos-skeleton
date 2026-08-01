<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanFaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:120'],
            'area' => ['nullable', 'string', 'max:100'],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'tipo_ejecucion' => ['nullable', 'string', 'max:60'],
        ];
    }
}
