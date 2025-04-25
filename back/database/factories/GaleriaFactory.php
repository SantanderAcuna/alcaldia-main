<?php

namespace Database\Factories;
use App\Models\Galeria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galeria>
 */
class GaleriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Galeria::class;


    public function definition(): array
    {
        $tipos = ['imagen', 'documento'];
        $tipo = $this->faker->randomElement($tipos);

        return [
            'disco' => 'public',
            'ruta_archivo' => $this->faker->filePath(),
            'nombre_original' => $tipo == 'imagen'
                ? $this->faker->word().'.jpg'
                : $this->faker->word().'.pdf',
            'mime_type' => $tipo == 'imagen'
                ? 'image/jpeg'
                : 'application/pdf',
            'tamano_bytes' => $this->faker->numberBetween(1000, 10000000),
            'tipo_archivo' => $tipo,
            'metadatos' => [
                'autor' => $this->faker->name(),
                'fecha_subida' => now()->toDateTimeString()
            ],
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function imagen()
    {
        return $this->state([
            'mime_type' => 'image/jpeg',
            'tipo_archivo' => 'imagen',
            'nombre_original' => 'perfil-' . $this->faker->uuid . '.jpg'
        ]);
    }

    public function documento()
    {
        return $this->state([
            'mime_type' => 'application/pdf',
            'tipo_archivo' => 'documento',
            'nombre_original' => 'plan-desarrollo-' . $this->faker->uuid . '.pdf'
        ]);
    }

}
