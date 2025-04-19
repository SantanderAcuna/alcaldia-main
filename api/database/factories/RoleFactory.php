<?php

namespace Database\Factories;


use App\Models\Usuario\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Role::class;



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
