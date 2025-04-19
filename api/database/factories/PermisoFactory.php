<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permiso>
 */
class PermisoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Usuario\Permiso::class;

    public function definition(): array
    {
        // Conjunto cerrado de recursos y acciones
        $resources = ['posts', 'users', 'settings'];
        $actions   = ['create', 'edit', 'delete', 'view'];

        $resource = $this->faker->randomElement($resources);
        $action   = $this->faker->randomElement($actions);

        return [
            'nombre'    => "{$resource}.{$action}",   // Ej: users.view
            'grupo'     => $resource,                 // Ej: users
            'slug'      => "{$resource}-{$action}",   // Ej: users-view
            'is_active' => true,
        ];
    }
}
