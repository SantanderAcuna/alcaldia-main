<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanDeDesarrolloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        return $user && $user->tieneRol(['admin', 'superadmin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:500',
            'contenido' => 'nullable|string',
            'galeria_id' => 'required|exists:galerias,id',
            'alcalde_id' => 'required|exists:alcaldes,id'
        ];
    }

    public function messages(): array
    {
        return [
            'alcalde_id.exists' => 'El alcalde seleccionado no existe',
            'galeria_id.exists' => 'La galería no está registrada'
        ];
    }
}
