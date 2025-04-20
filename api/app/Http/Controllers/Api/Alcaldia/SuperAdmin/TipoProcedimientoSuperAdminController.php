<?php

namespace App\Http\Controllers\Api\Alcaldia\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreTipoProcedimientoRequest;
use App\Http\Requests\Alcaldia\UpdateTipoProcedimientoRequest;
use App\Models\Alcaldia\TipoProcedimiento;
use Illuminate\Http\Request;

class TipoProcedimientoSuperAdminController extends Controller
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


    public function update(UpdateTipoProcedimientoRequest $request, TipoProcedimiento $tipoProcedimiento)
    {
        $tipoProcedimiento->update($request->validated());
        return response()->json([
            'data' => $tipoProcedimiento->fresh(),
            'message' => 'Tipo actualizado'
        ], 200);
    }

    public function destroy(TipoProcedimiento $tipoProcedimiento){
        $this->checkRelations($tipoProcedimiento);
        $tipoProcedimiento->forceDelete();
        return response()->noContent();
    }

    protected function checkRelations(TipoProcedimiento $tipo): void
    {
        if ($tipo->funcionesMacro()->exists() || $tipo->procedimientosMacro()->exists()) {
            abort(409, 'No se puede eliminar: Tiene registros asociados');
        }
    }
}
