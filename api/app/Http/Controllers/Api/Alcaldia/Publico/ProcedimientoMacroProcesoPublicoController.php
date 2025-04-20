<?php

namespace App\Http\Controllers\Api\Alcaldia\Publico;

use App\Http\Controllers\Controller;
use App\Models\Alcaldia\ProcedimientoMacroProceso;
use Illuminate\Http\Request;

class ProcedimientoMacroProcesoPublicoController extends Controller
{
    public function index()
    {
        try {
            $procedimientos = ProcedimientoMacroProceso::with(['macroProceso', 'tipoProcedimiento'])
                ->where('estado', true)
                ->get();

            return response()->json($procedimientos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(ProcedimientoMacroProceso $procedimiento)
    {
        try {
            return response()->json($procedimiento->load('funcionMacroProceso'), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

  
}
