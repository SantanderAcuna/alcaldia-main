<?php

namespace Database\Factories;

use App\Models\Alcaldia\FuncionMacroProceso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FuncionMacroProceso>
 */
class FuncionMacroProcesoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = FuncionMacroProceso::class;

    public function definition(): array
    {
        return [
            'macro_proceso_id' => 1,
            'descripcion' => $this->faker->sentence(),
            'orden' => $this->faker->numberBetween(1, 20),
        ];
    }
}
