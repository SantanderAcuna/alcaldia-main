<?php

namespace Database\Factories;


use App\Models\Alcaldia\TipoProcedimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoProcedimiento>
 */
class TipoProcedimientoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = TipoProcedimiento::class;


    public function definition(): array
    {
        $options = ['Solicitud', 'Inspección', 'Trámite', 'Consulta'];
        return [
            'nombre'      => $this->faker->randomElement($options),
            'descripcion' => $this->faker->sentence(),
            'estado'      => $this->faker->boolean(90),
        ];
    }


}
