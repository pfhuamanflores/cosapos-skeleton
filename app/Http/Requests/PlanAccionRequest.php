<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanAccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tieneRol(\App\Models\Rol::GERENTE_PROYECTO);
    }

    public function rules(): array
    {
        return [
            'descripcion' => ['required', 'string', 'max:1000'],
            'responsable' => ['required', 'string', 'max:150'],
            'fecha_compromiso' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
