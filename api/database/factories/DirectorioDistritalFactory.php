<?php

namespace Database\Factories;

use App\Models\Alcaldia\DirectorioDistrital;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alcaldia\DirectorioDistrital>
 */
class DirectorioDistritalFactory extends Factory
{
    protected $model = DirectorioDistrital::class;

    public function definition(): array
    {
        $tipos = [
            'SECRETARÍA',
            'INSTITUTO',
            'DESCENTRALIZADO',
            'JEFATURA',
            'ASESORÍA',
            'SUBDIRECCIÓN'
        ];

        return [
            'nombre' => fake()->company(),
            'funcionario' => fake()->name(),
            'correo' => fake()->unique()->companyEmail(),
            'red_social' => fake()->optional()->url(),
            'tipo_entidad' => fake()->randomElement($tipos)
        ];
    }
}
