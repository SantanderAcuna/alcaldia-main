<?php

namespace App\Http\Controllers\Api\Alcaldia\Publico;

use App\Http\Controllers\Controller;
use App\Models\Alcaldia\Alcalde;
use App\Models\Alcaldia\Dependencia;
use Illuminate\Http\Request;

class DependenciaPublicoController extends Controller
{
    public function index()
    {
        $dependencias = Dependencia::with(['macroProcesos' => fn($q) => $q->active()])
            ->advancedFilter()
            ->paginate(request('per_page', 10))
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $dependencias,
            'meta' => [
                'total' => Dependencia::count()
            ]
        ], 200);
    }

    public function show(Dependencia $dependencia)
    {
        $dependencia->load([
            'macroProcesos.tipoProcedimientos',
            'gabinetes.user.perfil',
            'directoriosDistritales.foto'
        ]);

        return response()->json([
            'success' => true,
            'data' => $dependencia,
            'message' => 'Dependencia con todas las relaciones'
        ], 200);
    }
}
