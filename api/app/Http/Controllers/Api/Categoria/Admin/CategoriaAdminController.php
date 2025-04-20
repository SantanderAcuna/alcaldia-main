<?php

namespace App\Http\Controllers\Api\Categoria\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categoria\StoreCategoriaRequest;
use App\Models\Menu\Categoria;
use Illuminate\Http\Request;

class CategoriaAdminController extends Controller
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

    public function store(StoreCategoriaRequest $request)
    {
        $categoria = Categoria::create($request->validated());

        return response()->json([
            'data' => $categoria,
            'message' => 'Categoría creada exitosamente'
        ], 201);
    }
}
