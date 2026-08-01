<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->tieneRol(\App\Models\Rol::ADMIN_SISTEMA);
    }

    public function rules(): array
    {
        $usuarioId = $this->route('usuario')?->id;

        return [
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'correo' => ['required', 'email', Rule::unique('usuarios', 'correo')->ignore($usuarioId)],
            'password' => [$usuarioId ? 'nullable' : 'required', 'string', 'min:8'],
            'rol_id' => ['required', 'exists:roles,id'],
            'activo' => ['boolean'],
        ];
    }
}
