<?php

namespace App\Http\Requests\Usuario\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilRequest  extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('superadmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dependencia_id' => 'nullable|exists:dependencias,id',
            'titulo_profesional' => 'nullable|string|max:200',
            'especializacion' => 'nullable|string|max:200',
            'doctorado' => 'nullable|string|max:200',
            'foto_url' => 'nullable|url|max:500',
            'resumen_biografico' => 'nullable|string|max:1000',
            'experiencia_publica' => 'nullable|json'
        ];
    }
}
