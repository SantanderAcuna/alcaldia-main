<?php

namespace Database\Factories;

use App\Models\Menu\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Categoria::class;

    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->unique()->word(),
            'slug' => $this->faker->unique()->slug(),
            'descripcion' => $this->faker->optional()->text(100),
        ];
    }
}
