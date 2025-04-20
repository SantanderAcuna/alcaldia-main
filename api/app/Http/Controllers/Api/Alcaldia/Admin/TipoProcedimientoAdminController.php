<?php

namespace App\Http\Controllers\Api\Alcaldia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreTipoProcedimientoRequest;
use App\Models\Alcaldia\TipoProcedimiento;
use Illuminate\Http\Request;

class TipoProcedimientoAdminController extends Controller
{

    public function index()
    {
        $tipos = TipoProcedimiento::with(['funcionesMacro'])
            ->latest()
            ->paginate(15);

        return response()->json([
            'data' => $tipos,
            'meta' => [
                'total_activos' => TipoProcedimiento::activos()->count()
            ]
        ], 200);
    }
    
    public function show(TipoProcedimiento $tipoProcedimiento)
    {
        return response()->json([
            'data' => $tipoProcedimiento->load(['funcionesMacro', 'procedimientosMacro']),
            'message' => 'Detalle del tipo de procedimiento'
        ], 200);
    }


    public function store(StoreTipoProcedimientoRequest $request)
    {
        $tipo = TipoProcedimiento::create($request->validated());
        return response()->json([
            'data' => $tipo,
            'message' => 'Tipo de procedimiento creado'
        ], 201);
    }
}
