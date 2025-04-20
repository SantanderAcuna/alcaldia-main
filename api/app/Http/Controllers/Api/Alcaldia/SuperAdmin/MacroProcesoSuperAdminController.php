<?php

namespace App\Http\Controllers\Api\Alcaldia\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreMacroProcesoRequest;
use App\Http\Requests\Alcaldia\UpdateMacroProcesoRequest;
use App\Models\Alcaldia\MacroProceso;
use Illuminate\Http\Request;

class MacroProcesoSuperAdminController extends Controller
{
    public function index()
    {
        $procesos = MacroProceso::withTrashed()
            ->with(['dependencia', 'tipoProcedimientos'])
            ->advancedFilter()
            ->paginate(20);

        return response()->json([
            'data' => $procesos,
            'meta' => [
                'deleted' => MacroProceso::onlyTrashed()->count()
            ]
        ], 200);
    }

    public function show(MacroProceso $macroProceso)
    {
        return response()->json([
            'data' => $macroProceso->load([
                'dependencia.gabinetes',
                'tipoProcedimientos.funciones'
            ]),
            'message' => 'Detalle completo con relaciones profundas'
        ], 200);
    }

    public function store(StoreMacroProcesoRequest $request)
    {
        $macroProceso = MacroProceso::create($request->validated());
        return response()->json([
            'data' => $macroProceso,
            'message' => 'Macroproceso creado con privilegios de superadmin'
        ], 201);
    }

    public function update(UpdateMacroProcesoRequest $request, MacroProceso $macroProceso)
    {
        $macroProceso->update($request->validated());
        return response()->json([
            'data' => $macroProceso->fresh(['dependencia', 'tipoProcedimientos']),
            'message' => 'Actualización completa de registro'
        ], 200);
    }

    public function destroy(MacroProceso $macroProceso)
    {
        $this->checkProcedimientosAsociados($macroProceso);
        $macroProceso->forceDelete();
        return response()->noContent();
    }

    public function restore($id)
    {
        $macroProceso = MacroProceso::onlyTrashed()->findOrFail($id);
        $macroProceso->restore();
        return response()->json([
            'data' => $macroProceso,
            'message' => 'Macroproceso restaurado'
        ], 200);
    }

    protected function checkProcedimientosAsociados(MacroProceso $macroProceso): void
    {
        if ($macroProceso->tipoProcedimientos()->exists()) {
            abort(409, 'Acción no permitida: Existen procedimientos relacionados');
        }
    }
}
