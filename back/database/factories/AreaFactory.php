<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->jobTitle . ' ' . $this->faker->randomNumber(3),// Nombre único de hasta 150 caracteres
            'area_id' => Area::factory(), // Relación con Area
            'user_id' => User::factory(), // Relación con User
            'is_lider' => $this->faker->boolean(10), // 30% de probabilidad de ser líder
        ];
    }

    /**
     * Configuración adicional para el factory
     */
    public function configure()
    {
        return $this->afterCreating(function ($modelo) {
            // Lógica adicional después de crear si es necesaria
        });
    }

    /**
     * Estado para marcar como líder
     */
    public function lider()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_lider' => true,
            ];
        });
    }

    /**
     * Estado para marcar como no líder
     */
    public function noLider()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_lider' => false,
            ];
        });
    }
}
