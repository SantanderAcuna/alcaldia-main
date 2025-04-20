<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDependenciaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        return $user && $user->tieneRol(['superadmin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:150|unique:dependencias,nombre,'.$this->dependencia->id,
            'descripcion' => 'nullable|string|max:500',
            'correo' => 'nullable|email|max:150',
            'telefono' => 'nullable|string|max:20|regex:/^[0-9\-\+\(\) ]+$/',
            'direccion' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id'
        ];
    }
}
