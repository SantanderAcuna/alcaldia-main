<?php

namespace Database\Factories;

use App\Models\Dependencia;
use App\Models\Perfil;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gabinete>
 */
class GabineteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $inicio = $this->faker->dateTimeBetween('-2 years', 'now'); // inicio coherente

        return [
            // FK: se rellenan con ->state() o ->for() desde otros factories.
            'user_id'        => User::factory(),
            'perfil_id'      => Perfil::factory(),
            'dependencia_id' => Dependencia::factory(),

            // Datos propios del cargo
            'cargo'          => $this->faker->jobTitle(),
            'actual'         => $this->faker->boolean(70),          // 70 % vigentes
            'fecha_inicio'   => $inicio->format('Y-m-d'),
            'fecha_fin'      => $this->faker->boolean(30)           // 30 % han terminado
                                 ? $this->faker->dateTimeBetween($inicio, '+4 years')->format('Y-m-d')
                                 : null,
        ];
    }
}
