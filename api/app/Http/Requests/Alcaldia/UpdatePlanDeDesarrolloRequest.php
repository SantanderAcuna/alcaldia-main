<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanDeDesarrolloRequest extends FormRequest
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
            'titulo' => 'sometimes|string|max:500',
            'contenido' => 'nullable|string',
            'galeria_id' => 'sometimes|exists:galerias,id',
            'alcalde_id' => 'sometimes|exists:alcaldes,id'
        ];
    }
}
