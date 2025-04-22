<?php

namespace Database\Seeders;

use App\Models\Alcalde;
use App\Models\Categoria;
use App\Models\Dependencia;
use App\Models\DirectorioDistrital;
use App\Models\FuncionMacroProceso;
use App\Models\Gabinete;
use App\Models\Galeria;
use App\Models\MacroProceso;
use App\Models\Perfil;
use App\Models\Permiso;
use App\Models\PlanDeDesarrollo;
use App\Models\ProcedimientoMacroProceso;
use App\Models\Rol;
use App\Models\TipoEntidad;
use App\Models\TipoProcedimiento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1) Permisos fijos (no factory)
        $resources = ['posts', 'users', 'settings'];
        $actions   = ['create', 'edit', 'delete', 'view'];

        foreach ($resources as $res) {
            foreach ($actions as $act) {
                Permiso::updateOrCreate(
                    ['nombre' => "{$res}.{$act}"],
                    ['grupo' => $res, 'slug' => "{$res}-{$act}", 'is_active' => true]
                );
            }
        }

        // 2) Roles fijos usando factory sequence
        Rol::factory()
            ->count(5)
            ->sequence(
                ['name' => 'admin',   'slug' => 'admin',   'label' => 'Admin',   'is_active' => true],
                ['name' => 'editor',  'slug' => 'editor',  'label' => 'Editor',  'is_active' => true],
                ['name' => 'user',    'slug' => 'user',    'label' => 'User',    'is_active' => true],
                ['name' => 'manager', 'slug' => 'manager', 'label' => 'Manager', 'is_active' => true],
                ['name' => 'guest',   'slug' => 'guest',   'label' => 'Guest',   'is_active' => true]
            )
            ->create();

        // 3) Tipos de procedimiento fijos
        $types = ['Solicitud', 'Inspección', 'Trámite', 'Consulta'];
        foreach ($types as $type) {
            TipoProcedimiento::updateOrCreate(
                ['nombre' => $type],
                ['descripcion' => null, 'estado' => true]
            );
        }

        // 4) Categorías
        Categoria::factory(10)->create();

        // 5) Dependencias
        Dependencia::factory(10)->create();
        $depIds = Dependencia::pluck('id')->toArray();

        // 6) Galerías asignadas a Dependencias: 3 por cada una
        foreach ($depIds as $depId) {
            Galeria::factory(3)->create([
                'galeriaable_type' => Dependencia::class,
                'galeriaable_id' => $depId,
            ]);
        }

        // 7) MacroProcesos y sub-modelos
        MacroProceso::factory(5)->create();
        FuncionMacroProceso::factory(10)->create();
        ProcedimientoMacroProceso::factory(10)->create();

        // 8) Usuarios y Perfiles
        $userIds = User::factory(50)->create()->pluck('id')->toArray();
        $perfilIds = Perfil::factory(50)->create()->pluck('id')->toArray();

        // 9) Gabinetes con relaciones válidas
        Gabinete::factory(20)
            ->state(fn() => [
                'user_id' => Arr::random($userIds),
                'dependencia_id' => Arr::random($depIds),
                'perfil_id' => Arr::random($perfilIds),
            ])
            ->create();

        // 10) Alcaldes y Planes de Desarrollo
        Alcalde::factory(5)->create();
        PlanDeDesarrollo::factory(5)->create();

        // 11) TipoEntidad y DirectorioDistrital
        $entityTypes = [
            'Secretaría',
            'Instituto',
            'Oficina',
            'Agencia',
            'Departamento',
            'Unidad',
            'Comisión',
            'Dirección',
            'Oficina Técnica',
            'Oficina Jurídica'
        ];

        foreach ($entityTypes as $name) {
            TipoEntidad::updateOrCreate(
                ['nombre' => $name],
                [
                    'slug' => Str::slug($name),
                    'descripcion' => null,
                    'nivel_jerarquico' => 1,
                    'activo' => true
                ]
            );
        }
        DirectorioDistrital::factory(20)->create();
    }
}
