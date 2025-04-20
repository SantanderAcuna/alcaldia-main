<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubdireccionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:150|unique:subdirecciones,nombre',
            'codigo' => 'required|string|max:50|unique:subdirecciones,codigo',
            'dependencia_id' => 'required|exists:dependencias,id',
            'descripcion' => 'nullable|string|max:500',
            'estado' => 'required|boolean'
        ];
    }
}
