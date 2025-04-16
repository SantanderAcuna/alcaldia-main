<?php

namespace Database\Factories;

use App\Models\Galeria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galeria>
 */
class GaleriaFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Galeria::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->optional()->word(),
            'ruta' => $this->faker->filePath(),
            'tipo' => $this->faker->randomElement(['imagen', 'documento', 'video', 'audio']),
            'extension' => $this->faker->fileExtension(),
            'tamano' => $this->faker->numberBetween(10000, 5000000),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
