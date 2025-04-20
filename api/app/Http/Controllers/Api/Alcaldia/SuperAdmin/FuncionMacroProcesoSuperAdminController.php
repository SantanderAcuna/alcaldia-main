<?php

namespace App\Http\Controllers\Api\Alcaldia\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreFuncionMacroProcesoRequest;
use App\Http\Requests\Alcaldia\UpdateFuncionMacroProcesoRequest;
use App\Models\Alcaldia\FuncionMacroProceso;
use Illuminate\Http\Request;

class FuncionMacroProcesoSuperAdminController extends Controller
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

    public function store(StoreFuncionMacroProcesoRequest $request)
    {
        $funcion = FuncionMacroProceso::create($request->validated());
        return response()->json([
            'data' => $funcion,
            'message' => 'Función creada exitosamente'
        ], 201);
    }


    public function update(UpdateFuncionMacroProcesoRequest $request, FuncionMacroProceso $funcionMacroProceso)
    {
        $funcionMacroProceso->update($request->validated());
        return response()->json([
            'data' => $funcionMacroProceso->fresh(),
            'message' => 'Función actualizada'
        ], 200);
    }

    public function destroy(FuncionMacroProceso $funcionMacroProceso)
    {
        $funcionMacroProceso->forceDelete();
        return response()->noContent();
    }

    public function restore($id)
    {
        $funcion = FuncionMacroProceso::onlyTrashed()->findOrFail($id);
        $funcion->restore();
        return response()->json([
            'data' => $funcion,
            'message' => 'Función restaurada'
        ], 200);
    }

}
