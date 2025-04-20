<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcedimientoMacroProcesoRequest extends FormRequest
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
            'macro_proceso_id' => 'required|exists:macro_procesos,id',
            'tipo_procedimiento_id' => 'nullable|exists:tipo_procedimientos,id',
            'funcion_macro_proceso_id' => 'nullable|exists:funcion_macro_procesos,id',
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:500',
            'orden' => 'required|integer|min:1',
            'estado' => 'required|boolean'
        ];
    }
}
