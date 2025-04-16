<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Alcaldia\Dependencia;

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
    protected $model = Dependencia::class;

    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->unique()->company(),
            'descripcion' => $this->faker->optional()->text(100),
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->address(),
            'user_id' => 1,
        ];
    }
}
