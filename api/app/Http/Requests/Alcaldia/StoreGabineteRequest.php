<?php

namespace App\Http\Requests\Alcaldia;

use App\Models\Alcaldia\Gabinete;
use Illuminate\Foundation\Http\FormRequest;

class StoreGabineteRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'dependencia_id' => 'required|exists:dependencias,id',
            'perfil_id' => 'required|exists:perfiles,id',
            'cargo' => 'nullable|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'actual' => 'boolean'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->actual && Gabinete::where('user_id', $this->user_id)
                ->where('actual', true)
                ->exists()) {
                $validator->errors()->add('actual', 'El usuario ya tiene un cargo activo');
            }
        });
    }
}
