<?php

namespace App\Http\Requests\Usuario\Seguridad;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => 'required|string|max:50|unique:roles',
            'slug' => 'required|string|max:60|unique:roles',
            'label' => 'required|string|max:100',
            'is_active' => 'boolean'
        ];
    }
}
