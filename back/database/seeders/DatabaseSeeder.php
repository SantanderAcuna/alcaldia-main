<?php

namespace Database\Seeders;

use App\Models\Alcalde;
use App\Models\Area;
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
use App\Models\Subdireccion;
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
        $actions = ['create', 'edit', 'delete', 'view'];

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
                ['name' => 'admin', 'slug' => 'admin', 'label' => 'Admin', 'is_active' => true],
                ['name' => 'editor', 'slug' => 'editor', 'label' => 'Editor', 'is_active' => true],
                ['name' => 'user', 'slug' => 'user', 'label' => 'User', 'is_active' => true],
                ['name' => 'manager', 'slug' => 'manager', 'label' => 'Manager', 'is_active' => true],
                ['name' => 'guest', 'slug' => 'guest', 'label' => 'Guest', 'is_active' => true]
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

        // Crear 10 galerías aleatorias
        $galerias = Galeria::factory(10)->create();

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

        // 9) Gabinetes con relaciones válidas sin repetir combinaciones
        $used = []; // para llevar un registro de las tripletas ya creadas

        for ($i = 0; $i < 20; $i++) {
            do {
                $user_id        = Arr::random($userIds);
                $dependencia_id = Arr::random($depIds);
                $perfil_id      = Arr::random($perfilIds);

                // clave simple para detectar duplicados
                $key = "{$user_id}-{$dependencia_id}-{$perfil_id}";
            } while (in_array($key, $used));

            // marcamos esta combinación como usada
            $used[] = $key;

            // creamos el gabinete con esa tripleta única
            Gabinete::factory()->create([
                'user_id'        => $user_id,
                'dependencia_id' => $dependencia_id,
                'perfil_id'      => $perfil_id,
            ]);
        }

        // 10) Alcaldes
        Alcalde::factory(5)
            ->afterCreating(function (Alcalde $alcalde) use ($galerias) {
                // Asignar foto aleatoria
                $alcalde->foto()->associate(
                    $galerias->where('tipo_archivo', 'imagen')->random()
                );
                $alcalde->save();

                // Crear planes de desarrollo (1-3 por alcalde)
                PlanDeDesarrollo::factory(rand(1, 3))
                    ->create([
                        'alcalde_id' => $alcalde->id,
                        'galeria_id' => Galeria::factory()->documento()->create()->id
                    ]);
            })
            ->create();

        // Alcalde actual especial
        $alcaldeActual = Alcalde::factory()
            ->create([
                'nombre_completo' => 'Juan Pérez',
                'actual' => true
            ]);

        // Foto para alcalde actual
        $alcaldeActual->foto()->associate(
            Galeria::factory()->imagen()->create()
        );
        $alcaldeActual->save();

        // Plan de desarrollo para alcalde actual
        PlanDeDesarrollo::factory()
            ->create([
                'alcalde_id' => $alcaldeActual->id,
                'galeria_id' => Galeria::factory()->documento()->create()->id,
                'titulo' => 'Plan de Desarrollo 2023-2026'
            ]);

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
        // 12a) Crear 10 áreas “raíz” sin depender de ninguna
        $roots = Area::factory(10)->create();

        // 12b) Crear 40 áreas “hijas” apuntando a un padre aleatorio
        Area::factory(40)
            ->state(fn() => ['area_id' => Arr::random($roots->pluck('id')->toArray())])
            ->create();
        Subdireccion::factory()->count(50)->create();
    }
}
