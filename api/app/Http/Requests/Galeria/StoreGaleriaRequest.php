<?php

namespace App\Http\Requests\Galeria;

use Illuminate\Foundation\Http\FormRequest;

class StoreGaleriaRequest extends FormRequest
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
            'archivo' => 'required|file|max:10240',
            'disco' => 'required|in:public,privado',
            'galeriaable_type' => 'required|string',
            'galeriaable_id' => 'required|integer'
        ];
    }
}
