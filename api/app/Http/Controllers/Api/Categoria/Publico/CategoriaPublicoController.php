<?php

namespace App\Http\Controllers\Api\Categoria\Publico;

use App\Http\Controllers\Controller;
use App\Models\Menu\Categoria;
use Illuminate\Http\Request;

class CategoriaPublicoController extends Controller
{
    public function index()
    {
        $categorias = Categoria::conRelaciones()
            ->filter(request(['search', 'con_directorios']))
            ->paginate(10);

        return response()->json($categorias, 200);
    }

    public function show(Categoria $categoria)
    {
        return response()->json([
            'data' => $categoria->load(['directorios.foto']),
            'meta' => [
                'total_directorios' => $categoria->directorios()->count()
            ]
        ]);
    }
}
