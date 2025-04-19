<?php

namespace Database\Factories;

use App\Models\Alcaldia\Dependencia;
use App\Models\Alcaldia\Gabinete;
use App\Models\Usuario\Perfil;
use App\Models\Usuario\Role;
use App\Models\Usuario\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;


class GabineteFactory extends Factory
{
    protected $model = Gabinete::class;

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
