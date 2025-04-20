<?php

namespace App\Http\Requests\Alcaldia;

use Illuminate\Foundation\Http\FormRequest;

class StoreDirectorioRequest extends FormRequest
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
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:150',
            'cargo' => 'required|string|max:100',
            'email' => 'required|email|unique:directorio_distritals',
            'contactos' => 'required|json',
            'tipo_entidad_id' => 'required|exists:tipo_entidades,id',
            'foto_id' => 'nullable|exists:galerias,id'
        ];
    }
}
