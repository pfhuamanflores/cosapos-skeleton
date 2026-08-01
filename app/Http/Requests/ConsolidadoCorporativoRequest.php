<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConsolidadoCorporativoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tieneRol(\App\Models\Rol::CONSOLIDADOR_CORPORATIVO);
    }

    public function rules(): array
    {
        return [
            'periodo' => ['required', 'date_format:Y-m', Rule::unique('consolidados_corporativos', 'periodo')],
        ];
    }
}
