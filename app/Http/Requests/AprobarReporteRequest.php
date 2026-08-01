<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AprobarReporteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tieneRol(\App\Models\Rol::GERENTE_PROYECTO);
    }

    public function rules(): array
    {
        return [
            'estado' => ['required', Rule::in(['Aprobado', 'Observado', 'Rechazado'])],
        ];
    }
}
