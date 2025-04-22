<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Galeria;
use App\Models\TipoEntidad;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DirectorioDistrital>
 */
class DirectorioDistritalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $casts = [
        'contactos' => 'array',
    ];
    public function definition(): array
    {
        return [
            // ✅ Relación con la tabla categorías
            'categoria_id' => Categoria::inRandomOrder()->first()?->id ?? 1,

            // ✅ Nombre y cargo
            'nombre' => $this->faker->name,
            'cargo' => $this->faker->jobTitle,

            // ✅ Correo electrónico único
            'email' => $this->faker->unique()->safeEmail,

            // ✅ Contactos en formato JSON
            'contactos' => [
                'telefonos' => [$this->faker->phoneNumber],
                'redes_sociales' => [
                    [
                        'nombre' => 'Facebook', // ✅ Campo requerido
                        'url' => $this->faker->url()
                    ],
                    [
                        'nombre' => 'Twitter',
                        'url' => $this->faker->url()
                    ]
                ]
            ],

            // ✅ Relación con tipo_entidad
            'tipo_entidad_id' => TipoEntidad::inRandomOrder()->first()?->id ?? 1,

            // ✅ Foto (puede ser null)
            'foto_id' => Galeria::inRandomOrder()->first()?->id,
        ];
    }
}
