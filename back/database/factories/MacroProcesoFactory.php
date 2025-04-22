<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MacroProceso>
 */
class MacroProcesoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->unique()->word(),
            'mision' => $this->faker->paragraph(),
            'vision' => $this->faker->optional()->paragraph(),
            'dependencia_id' => 1,
            'codigo' => $this->faker->unique()->bothify('COD###'),
            'organigrama_url' => $this->faker->imageUrl(),
            'estado' => true,
        ];
    }
}
