<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaContractualRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'monto_contrato' => ['required', 'numeric', 'min:0.01'],
            'fecha_firma' => ['required', 'date'],
            'estado_contrato' => ['required', 'string', 'max:40'],
        ];
    }
}
