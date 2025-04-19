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
            'disco'            => config('filesystems.default'),
            'ruta_archivo'     => 'galerias/'.$this->faker->uuid().'.jpg',
            'mime_type'        => 'image/jpeg',
            'tamano_bytes'     => $this->faker->numberBetween(50000,5_000_000),
            'metadatos'        => json_encode(['width'=>640,'height'=>480]),
            'galeriaable_type' => null,
            'galeriaable_id'   => null,
        ];
    }
}
