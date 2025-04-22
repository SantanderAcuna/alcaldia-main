<?php

namespace Database\Factories;

use App\Models\Alcalde;
use App\Models\Galeria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanDeDesarrollo>
 */
class PlanDeDesarrolloFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(6),
            'contenido' => fake()->paragraphs(3, true),
            'galeria_id' => Galeria::factory(), // Crea una galería automáticamente
            'alcalde_id' => Alcalde::factory(), // Crea un alcalde automáticamente
        ];
    }
}
