<?php

namespace Database\Factories;

use App\Models\Alcaldia\FuncionMacroProceso;
use App\Models\Alcaldia\MacroProceso;
use App\Models\Alcaldia\ProcedimientosMacroProceso;
use App\Models\Alcaldia\Tipo_Procedimiento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsAlcaldiaProcedimientosMacroProceso>
 */
class ProcedimientosMacroProcesoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = ProcedimientosMacroProceso::class;

    public function definition()
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
