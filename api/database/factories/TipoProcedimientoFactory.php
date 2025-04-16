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
        return [
            //
            'nombre' => $this->faker->unique()->words(2, true),
            'descripcion' => $this->faker->sentence(),
            'estado' => true,
        ];
    }


}
