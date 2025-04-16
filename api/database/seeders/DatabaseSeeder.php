<?php

namespace Database\Seeders;

use App\Models\Alcaldia\Dependencia;
use App\Models\Alcaldia\FuncionMacroProceso;
use App\Models\Alcaldia\MacroProceso;
use App\Models\Alcaldia\ProcedimientosMacroProceso;


use App\Models\Categoria;
use App\Models\Galeria;
use App\Models\Alcaldia\TipoProcedimiento;
use App\Models\Perfil;
use App\Models\Permiso;

use App\Models\Role;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Datos base sin relaciones
        Role::factory(15)->create();
        User::factory(15)->create();
        Permiso::factory(15)->create();
        Categoria::factory(15)->create();
        Dependencia::factory(15)->create();
        Perfil::factory(15)->create();
        Galeria::factory(15)->create();

        // Datos requeridos por ProcedimientosMacroProceso
        TipoProcedimiento::factory(13)->create();  // ← asegura IDs válidos: 1, 2, 3
        MacroProceso::factory(13)->create();
        FuncionMacroProceso::factory(13)->create();
        
        MacroProceso::factory()->count(31)->create();              // 👈 IDs: 1, 2, 3
        FuncionMacroProceso::factory()->count(31)->create();       // 👈 IDs: 1, 2, 3
        ProcedimientosMacroProceso::factory()->count(15)->create(); // 👈 ahora puede usar IDs válidos


        User::factory()->create([
            'name' => 'jose acuña',
            'email' => 'santanderjose19@gmail.com',
            'password' => '85154239',

        ]);
    }
}
