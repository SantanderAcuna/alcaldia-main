<?php

namespace App\Http\Controllers\Api\Alcaldia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreMacroProcesoRequest;
use App\Models\Alcaldia\MacroProceso;
use Illuminate\Http\Request;

class MacroProcesoAdminController extends Controller
{
    public function index()
    {
        $procesos = MacroProceso::with(['dependencia:id,nombre'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => $procesos,
            'meta' => [
                'total_activos' => MacroProceso::where('estado', true)->count()
            ]
        ], 200);
    }

    public function store(StoreMacroProcesoRequest $request)
    {
        $macroProceso = MacroProceso::create($request->validated());

        return response()->json([
            'data' => $macroProceso,
            'message' => 'Macroproceso creado exitosamente'
        ], 201);
    }

    public function show(MacroProceso $macroProceso)
    {
        return response()->json([
            'data' => $macroProceso->load(['tipoProcedimientos']),
            'message' => 'Detalle administrativo'
        ], 200);
    }
}
