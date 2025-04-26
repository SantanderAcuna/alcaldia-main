<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
            'nombre'   => $this->faker->jobTitle . ' ' . $this->faker->randomNumber(3),
            // Tomamos un área ya existente al azar; si no hay ninguna, usamos 1 (o el que prefieras)
            'area_id'  => Area::pluck('id')->isNotEmpty()
                            ? Arr::random(Area::pluck('id')->toArray())
                            : 1,
            'user_id'  => User::factory(),
            'is_lider' => $this->faker->boolean(10),
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
