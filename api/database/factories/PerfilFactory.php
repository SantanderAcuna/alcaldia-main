<?php

namespace Database\Factories;

use App\Models\Usuario\Perfil;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perfil>
 */
class PerfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Perfil::class;

    public function definition(): array
    {


        return [
            //
            'user_id' => 1,
            'dependencia_id' => 1,
            'titulo_profesional' => $this->faker->jobTitle(),
            'especializacion' => $this->faker->word(),
            'doctorado' => $this->faker->word(),
            'foto_url' => $this->faker->imageUrl(),
            'resumen_biografico' => $this->faker->paragraph(),
            'experiencia_publica' => json_encode([
                $this->faker->jobTitle(),
                $this->faker->jobTitle()
            ]),

        ];
    }
}
