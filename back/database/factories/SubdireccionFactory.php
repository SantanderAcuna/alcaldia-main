<?php

namespace Database\Factories;

use App\Models\Dependencia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subdireccion>
 */
class SubdireccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->company,
            'descripcion' => $this->faker->paragraph,
            'dependencia_id' => Dependencia::factory(),
            'estado' => $this->faker->boolean(90) // 90% de probabilidad de estar activo
        ];
    }

    public function activa()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => true,
            ];
        });
    }

    public function inactiva()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => false,
            ];
        });
    }
}
