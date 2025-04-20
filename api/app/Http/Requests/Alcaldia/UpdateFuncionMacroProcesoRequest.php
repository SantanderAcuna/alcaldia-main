<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFuncionMacroProcesoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('superadmin');
    }

    public function rules(): array
    {
        return [
            'descripcion' => 'sometimes|string|max:1000',
            'orden' => [
                'sometimes',
                'integer',
                Rule::unique('funcion_macro_procesos')
                    ->where('macro_proceso_id', $this->funcionMacroProceso->macro_proceso_id)
                    ->ignore($this->funcionMacroProceso->id)
            ]
        ];
    }
}
