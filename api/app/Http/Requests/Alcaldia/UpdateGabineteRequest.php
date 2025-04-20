<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGabineteRequest extends FormRequest
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
            'cargo' => 'sometimes|string|max:100',
            'fecha_inicio' => 'sometimes|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'actual' => 'sometimes|boolean'
        ];
    }
}
