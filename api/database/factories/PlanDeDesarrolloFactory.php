<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Galeria;

use App\Models\Alcaldia\Alcalde;
use App\Models\Alcaldia\PlanDeDesarrollo;

class PlanDeDesarrolloFactory extends Factory
{
    protected $model = PlanDeDesarrollo::class;

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
