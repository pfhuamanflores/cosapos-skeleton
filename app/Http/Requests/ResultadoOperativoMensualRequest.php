<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResultadoOperativoMensualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'periodo' => ['required', 'date_format:Y-m', Rule::unique('resultados_operativos_mensuales', 'periodo')
                ->where('proyecto_id', $this->route('proyecto')->id)],
            'avance_fisico' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
