<?php

namespace App\Http\Controllers\Api\Alcaldia\Publico;

use App\Http\Controllers\Controller;
use App\Models\Alcaldia\TipoProcedimiento;
use Illuminate\Http\Request;

class TipoProcedimientoPublicoController extends Controller
{
    public function index()
    {
        $tipos = TipoProcedimiento::activos()
            ->orderBy('nombre')
            ->paginate(10);

        return response()->json([
            'data' => $tipos,
            'message' => 'Tipos de procedimiento activos'
        ], 200);
    }

    public function show(TipoProcedimiento $tipoProcedimiento)
    {
        return response()->json([
            'data' => $tipoProcedimiento->load(['funcionesMacro', 'procedimientosMacro']),
            'message' => 'Detalle del tipo de procedimiento'
        ], 200);
    }

}
