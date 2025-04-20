<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFuncionMacroProcesoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->tieneRol(['admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'macro_proceso_id' => 'required|exists:macro_procesos,id',
            'tipo_procedimiento_id' => 'nullable|exists:tipo_procedimientos,id',
            'descripcion' => 'required|string|max:1000',
            'orden' => [
                'nullable',
                'integer',
                Rule::unique('funcion_macro_procesos')
                    ->where('macro_proceso_id', $this->macro_proceso_id)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'orden.unique' => 'El orden ya está asignado para este macroproceso'
        ];
    }
}
