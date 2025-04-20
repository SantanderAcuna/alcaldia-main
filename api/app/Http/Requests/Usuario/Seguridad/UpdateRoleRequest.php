<?php

namespace App\Http\Requests\Usuarios\Seguridad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('roles')->ignore($this->role)
            ],
            'slug' => [
                'sometimes',
                'string',
                'max:60',
                Rule::unique('roles')->ignore($this->role)
            ],
            'label' => 'sometimes|string|max:100',
            'is_active' => 'sometimes|boolean'
        ];
    }
}
