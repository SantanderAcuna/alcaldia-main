<?php

namespace App\Http\Controllers\Api\Alcaldia\Publico;

use App\Http\Controllers\Controller;
use App\Models\Alcaldia\FuncionMacroProceso;
use Illuminate\Http\Request;

class FuncionMacroProcesoPublicoController extends Controller
{
    public function index()
    {
        $funciones = FuncionMacroProceso::with(['macroProceso', 'tipoProcedimiento'])
            ->ordenadas()
            ->paginate(20);

        return response()->json([
            'data' => $funciones,
            'message' => 'Funciones obtenidas'
        ], 200);
    }

    public function show(FuncionMacroProceso $funcionMacroProceso)
    {
        return response()->json([
            'data' => $funcionMacroProceso->load(['macroProceso.dependencia']),
            'message' => 'Detalle de función'
        ], 200);
    }
}
