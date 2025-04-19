<?php

namespace Database\Factories;




use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Alcaldia\Dependencia;


// database/factories/Alcaldia/DependenciaFactory.php

namespace Database\Factories;

use App\Models\Alcaldia\Dependencia;
use App\Models\Alcaldia\Gabinete;
use App\Models\Usuario\Perfil;
use App\Models\Usuario\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DependenciaFactory extends Factory
{

    protected $model = Dependencia::class; // Relación directa con el modelo

   public function definition(): array
{
    return [
        'nombre'      => $this->faker->company(),
        'descripcion' => $this->faker->catchPhrase(),
        'correo'      => $this->faker->companyEmail(),
        'telefono'    => $this->faker->phoneNumber(),
        'direccion'   => $this->faker->address(),
        'user_id'     => 1,
    ];
}



}
