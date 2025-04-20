<?php

namespace App\Http\Controllers\Api\Alcaldia\Publico;

use App\Http\Controllers\Controller;
use App\Models\Alcaldia\MacroProceso;
use Illuminate\Http\Request;

class MacroProcesoPublicoController extends Controller
{
    public function index()
    {
        $procesos = MacroProceso::activos()
            ->conDependencia()
            ->paginate(10);

        return response()->json([
            'data' => $procesos,
            'message' => 'Macroprocesos activos obtenidos'
        ], 200);
    }

    public function show(MacroProceso $macroProceso)
    {
        return response()->json([
            'data' => $macroProceso->load(['dependencia', 'tipoProcedimientos']),
            'message' => 'Detalle completo del macroproceso'
        ], 200);
    }
}
