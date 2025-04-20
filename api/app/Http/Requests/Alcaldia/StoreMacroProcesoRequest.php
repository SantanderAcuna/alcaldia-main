<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class StoreMacroProcesoRequest extends FormRequest
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
            'nombre' => 'required|string|max:150|unique:macro_procesos',
            'mision' => 'required|string|max:1000',
            'vision' => 'nullable|string|max:1000',
            'dependencia_id' => 'required|exists:dependencias,id',
            'codigo' => 'nullable|string|max:50|unique:macro_procesos',
            'organigrama_url' => 'nullable|url|max:500',
            'estado' => 'boolean'
        ];
    }
}
