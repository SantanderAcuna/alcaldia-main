<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubdireccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('superadmin');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:150|unique:subdirecciones,nombre,' . $this->subdireccion,
            'codigo' => 'sometimes|string|max:50|unique:subdirecciones,codigo,' . $this->subdireccion,
            'dependencia_id' => 'sometimes|exists:dependencias,id',
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'sometimes|boolean'
        ];
    }
}
