<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoEntidad>
 */
class TipoEntidadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\TipoEntidad::class;

    public function definition(): array
    {
        $nombre = $this->faker->unique()->randomElement([
            'SECRETARÍA', 'INSTITUTO', 'OFICINA', 'DIRECCIÓN', 'DEPARTAMENTO'
        ]);

        return [
            'nombre' => $nombre,
            'slug' => Str::slug(strtolower($nombre)),
            'descripcion' => $this->faker->optional()->sentence(),
            'nivel_jerarquico' => $this->faker->numberBetween(1, 5),
            'activo' => true,
        ];
    }
}
