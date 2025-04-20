<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMacroProcesoRequest extends FormRequest
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
            'nombre' => [
                'sometimes',
                'string',
                'max:150',
                Rule::unique('macro_procesos')->ignore($this->macroProceso)
            ],
            'mision' => 'sometimes|string|max:1000',
            'vision' => 'nullable|string|max:1000',
            'dependencia_id' => 'sometimes|exists:dependencias,id',
            'codigo' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('macro_procesos')->ignore($this->macroProceso)
            ],
            'organigrama_url' => 'nullable|url|max:500',
            'estado' => 'sometimes|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.unique' => 'El código ya está asignado a otro macroproceso',
            'dependencia_id.exists' => 'La dependencia seleccionada no existe'
        ];
    }
}
