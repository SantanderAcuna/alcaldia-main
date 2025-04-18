<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permiso>
 */
class PermisoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Usuario\Permiso::class;

    public function definition(): array
    {
        $grupo = $this->faker->randomElement(['usuarios', 'publicaciones', 'configuraciones']);
        $accion = $this->faker->randomElement(['crear', 'leer', 'actualizar', 'eliminar']);
        $nombre = "{$grupo}.{$accion}";

        return [
            'nombre' => $nombre,
            'grupo' => $grupo,
            'slug' => Str::slug("{$accion} {$grupo}"),
            'is_active' => true,
        ];
    }
}
