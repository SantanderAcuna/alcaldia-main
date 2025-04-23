<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dependencia>
 */
class DependenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->company, // Añade ->unique()
            'descripcion' => $this->faker->text(200),
            'correo' => $this->faker->unique()->companyEmail,
            'telefono' => $this->faker->unique()->phoneNumber,
            'direccion' => $this->faker->address,
            'user_id' => User::factory(),
        ];
    }
}
