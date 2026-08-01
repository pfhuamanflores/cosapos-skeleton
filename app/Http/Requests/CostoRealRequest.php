<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostoRealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'monto_neto' => ['required', 'numeric', 'min:0.01'],
            'fecha_registro' => ['required', 'date'],
            'tipo_moneda' => ['required', 'string', 'max:10'],
            'tipo_cambio' => ['required', 'numeric', 'min:0.0001'],
            'documento' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }
}
