<?php

namespace Database\Factories;

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
            'nombre'      => $this->faker->company(),
            'descripcion' => $this->faker->catchPhrase(),
            'correo'      => $this->faker->companyEmail(),
            'telefono'    => $this->faker->phoneNumber(),
            'direccion'   => $this->faker->address(),
            'user_id'     => 1,
        ];
    }
}
