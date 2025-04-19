<?php

namespace Database\Factories\Usuario;


use App\Models\Usuario\Perfil;
use App\Models\Usuario\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario\Perfil>
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
            'dependencia_id' => \App\Models\Alcaldia\Dependencia::factory(),
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
