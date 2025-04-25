<?php

namespace Database\Factories;

use App\Models\Alcalde;
use App\Models\Alcaldia\PlanDeDesarrollo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alcalde>
 */
class AlcaldeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Alcalde::class;

    public function definition()
    {
        return [
            'nombre_completo' => $this->faker->name,
            'cargo' => 'Alcalde Distrital ' . now()->format('Y'),
            'fecha_inicio' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'fecha_fin' => $this->faker->optional(0.3)->dateTimeBetween('now', '+5 years'),
            'objetivo' => $this->faker->paragraph,
            'actual' => $this->faker->boolean(70), // 70% de probabilidad de ser actual
        ];
    }



    // Estados personalizados
    public function actual()
    {
        return $this->state([
            'actual' => true,
            'fecha_fin' => null
        ]);
    }

    public function pasado()
    {
        return $this->state([
            'actual' => false,
            'fecha_fin' => $this->faker->dateTimeBetween('-5 years', '-1 day')
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Alcalde $alcalde) {
            // Asignar foto solo si no tiene una
            if (!$alcalde->foto_id) {
                $alcalde->foto()->associate(
                    \App\Models\Galeria::factory()->imagen()->create()
                );
                $alcalde->save();
            }
        });
    }

    public function conPlanDesarrollo()
    {
        return $this->afterCreating(function (\App\Models\Alcalde $alcalde) {
            PlanDeDesarrollo::factory()
                ->for($alcalde)
                ->create([
                    'galeria_id' => \App\Models\Galeria::factory()->documento()
                ]);
        });
    }
}
