<?php

namespace Database\Factories;

use App\Models\Alcaldia\Alcalde;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class alcaldesfactoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Alcalde::class;

    public function definition(): array
    {
        $fecha_inicio = fake()->dateTimeBetween('-5 years', 'now');
        $fecha_fin = fake()->boolean(70)
            ? fake()->dateTimeBetween($fecha_inicio, '+2 years')
            : null;

        return [
            'galeria_id' => \App\Models\Galeria::factory(), // Asume que existen galerías con IDs 1-100
            'nombre_completo' => fake()->name(),
            'cargo' => fake()->randomElement([
                'Alcalde Distrital',
                'Alcalde Municipal',
                'Alcalde Provincial',
                'Alcalde Distrital y Provincial',
            ]),
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'objetivo' => fake()->sentence(8),
            'actual' => is_null($fecha_fin) // Si no tiene fecha fin, se considera actual
        ];
    }
}
