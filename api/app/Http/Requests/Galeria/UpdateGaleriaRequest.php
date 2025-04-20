<?php

namespace App\Http\Requests\Galeria;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGaleriaRequest extends FormRequest
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
            'disco' => [
                'sometimes',
                'required',
                Rule::in(['public', 'privado', 's3'])
            ],
            'ruta_archivo' => 'sometimes|string|max:500',
            'metadatos' => 'nullable|array',
            'metadatos.*' => 'required',
            'galeriaable_type' => [
                'sometimes',
                'required',
                Rule::in([
                    'App\Models\Alcaldia\Alcalde',
                    'App\Models\Alcaldia\Dependencia',
                    'App\Models\Alcaldia\DirectorioDistrital'
                ])
            ],
            'galeriaable_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists($this->galeriaable_type, 'id')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'galeriaable_type.in' => 'Tipo de relación no válido',
            'galeriaable_id.exists' => 'El recurso relacionado no existe'
        ];
    }
}
