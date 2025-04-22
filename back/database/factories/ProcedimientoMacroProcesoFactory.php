<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProcedimientoMacroProceso>
 */
class ProcedimientoMacroProcesoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'macro_proceso_id' => $this->faker->numberBetween(1, 3),
                'macro_proceso_id' => $this->faker->numberBetween(1, 3),
                'tipo_procedimiento_id' => $this->faker->numberBetween(1, 3), // ❗ Asegura que los IDs existen
                'titulo' => $this->faker->sentence(3),
                'descripcion' => $this->faker->paragraph(),
                'estado' => true,
            ];
    }
}
