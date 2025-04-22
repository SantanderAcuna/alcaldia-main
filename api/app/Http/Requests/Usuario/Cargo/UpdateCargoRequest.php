<?php

namespace App\Http\Requests\Usuario\Cargo;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCargoRequest extends FormRequest
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
            'nombre'    => "required|string|max:150|unique:cargos,nombre,{$cargoId}", // Unicidad ignorando el registro actual
            'area_id'   => 'required|integer|exists:areas,id',                       // Clave foránea válida
            'user_id'   => 'required|integer|exists:users,id',                       // Clave foránea válida
            'is_lider'  => 'sometimes|boolean',                                      // Indicador booleano
        ];
    }
}
