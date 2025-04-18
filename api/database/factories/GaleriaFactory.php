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
            'disco' => 'public', // puedes ajustar según tus discos configurados
            'ruta_archivo' => $this->faker->filePath(),
            'mime_type' => $this->faker->mimeType(),
            'tamano_bytes' => $this->faker->numberBetween(50000, 5000000),
            'metadatos' => json_encode([
                'resolucion' => '1920x1080',
                'formato' => 'HD',
                'descripcion' => $this->faker->sentence()
            ]),
            'galeriaable_type' => 'App\\Models\\Alcaldia\\Publicacion', // ejemplo, cambia según tu modelo real
            'galeriaable_id' => 1, // puedes usar model factories para asociar dinámicamente si lo necesitas
            
        ];
    }
}
