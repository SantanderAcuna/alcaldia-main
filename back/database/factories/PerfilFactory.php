<?php

namespace Database\Factories;

use App\Models\Dependencia;
use App\Models\User;
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
    public function definition(): array
    {
        return [
            'user_id'           => User::factory(),
            'dependencia_id' => Dependencia::factory(),
            'titulo_profesional'=> $this->faker->jobTitle(),
            'especializacion'   => $this->faker->word(),
            'doctorado'         => $this->faker->boolean(20) ? $this->faker->word() : null,
            'foto_url'          => $this->faker->imageUrl(640, 480, true),
            'resumen_biografico'=> $this->faker->paragraphs(2, true),
            'experiencia_publica'=> json_encode($this->faker->randomElements(
                                            ['Gestor', 'Docente', 'Analista'], 2)),
        ];
    }
}
