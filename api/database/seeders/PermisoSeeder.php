<?php

namespace Database\Seeders;

use App\Models\Usuario\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = ['usuarios', 'publicaciones', 'configuraciones'];
        $acciones = ['crear', 'leer', 'actualizar', 'eliminar'];

        foreach ($grupos as $grupo) {
            foreach ($acciones as $accion) {
                $nombre = "{$grupo}.{$accion}";

                Permiso::updateOrInsert(
                    ['nombre' => $nombre],
                    [
                        'grupo' => $grupo,
                        'slug' => Str::slug("{$accion} {$grupo}"),
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
