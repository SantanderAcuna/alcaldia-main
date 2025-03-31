<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pqrsd>
 */
class PqrsdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tipo' => $this->faker->randomElement(['Petición', 'Queja', 'Reclamo', 'Sugerencia', 'Denuncia']),
            'descripcion' => $this->faker->paragraph(),
            'estado' => $this->faker->randomElement(['Pendiente', 'En Proceso', 'Resuelto']),
        ];
    }
}
