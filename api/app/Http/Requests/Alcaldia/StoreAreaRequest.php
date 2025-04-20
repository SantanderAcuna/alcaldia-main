<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class StoreAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:150|unique:areas,nombre,NULL,id,subdireccion_id,' . $this->subdireccion_id,
            'subdireccion_id' => 'required|exists:subdirecciones,id'
        ];
    }
}
