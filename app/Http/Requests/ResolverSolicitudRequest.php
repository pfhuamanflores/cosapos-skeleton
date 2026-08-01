<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResolverSolicitudRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tieneRol(\App\Models\Rol::GERENTE_PROYECTO);
    }

    public function rules(): array
    {
        return [
            'estado' => ['required', Rule::in(['Aprobada', 'Observada', 'Rechazada'])],
            'observacion' => ['nullable', 'string', 'max:255', 'required_unless:estado,Aprobada'],
        ];
    }
}
