<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAreaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('superadmin');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|string|max:150|unique:areas,nombre,' . $this->area . ',id,subdireccion_id,' . $this->subdireccion_id,
            'subdireccion_id' => 'sometimes|exists:subdirecciones,id'
        ];
    }
}
