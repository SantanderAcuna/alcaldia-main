<?php

namespace Database\Factories;

use App\Models\Menu\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = $this->faker->unique()->word();
        return [
            'nombre'      => ucfirst($name),
            'slug'        => Str::slug($name),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
