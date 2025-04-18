<?php

namespace Database\Seeders;


use App\Models\Alcaldia\Alcalde;
use App\Models\Alcaldia\Dependencia;
use App\Models\Alcaldia\DirectorioDistrital;
use App\Models\Alcaldia\FuncionMacroProceso;
use App\Models\Alcaldia\MacroProceso;
use App\Models\Alcaldia\PlanDeDesarrollo;
use App\Models\Alcaldia\ProcedimientosMacroProceso;

use App\Models\Galeria;
use App\Models\Alcaldia\TipoProcedimiento;
use App\Models\Usuario\Perfil;
use App\Models\Menu\Categoria;
use App\Models\TipoEntidad;
use App\Models\Usuario\Role;
use App\Models\Usuario\Role_user;
use App\Models\Usuario\User;
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
        $this->call(PermisoSeeder::class);

        Categoria::factory(15)->create();
        Dependencia::factory(15)->create();
        Perfil::factory(15)->create();
        Galeria::factory(15)->create();
        TipoEntidad::factory(5)->create();

        // Datos base con relaciones

        TipoProcedimiento::factory(13)->create();
        MacroProceso::factory(13)->create();
        FuncionMacroProceso::factory(13)->create();
        MacroProceso::factory()->count(31)->create();
        FuncionMacroProceso::factory()->count(31)->create();
        ProcedimientosMacroProceso::factory()->count(15)->create();
        Alcalde::factory()->count(4)->create();
        PlanDeDesarrollo::factory()->count(4)->create();
        DirectorioDistrital::factory()->count(15)->create();
        User::factory()->create([
            'nombres' => 'Jose',
            'apellidos' => 'Acuña',
            'email' => 'santanderjose19@gmail.com',
            'password' => '85154239',
        ]);
    }
}
