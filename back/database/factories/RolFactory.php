<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rol>
 */
class RolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Roles reales del sistema
        $roles = ['admin', 'editor', 'user', 'manager', 'guest'];
        $name = $this->faker->unique()->randomElement($roles);


        return [
            'name'      => $name,            // Clave interna
            'slug'      => Str::slug($name), // URL-friendly
            'label'     => ucfirst($name),   // Etiqueta legible
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
