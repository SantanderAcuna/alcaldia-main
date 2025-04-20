<?php

namespace App\Http\Controllers\Api\Alcaldia\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreDependenciaRequest;
use App\Http\Requests\Alcaldia\UpdateDependenciaRequest;
use App\Models\Alcaldia\Dependencia;
use Illuminate\Http\Request;

class DependenciaSuperAdminController extends Controller
{
    public function index()
    {
        $dependencias = Dependencia::withTrashed()
            ->with(['responsable', 'macroProcesos', 'gabinetes'])
            ->advancedFilter()
            ->paginate(request('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $dependencias,
            'meta' => [
                'deleted' => Dependencia::onlyTrashed()->count()
            ]
        ], 200);
    }

    public function show(Dependencia $dependencia)
    {
        $dependencia->load([
            'macroProcesos.procedimientos',
            'gabinetes.user',
            'perfiles',
            'directoriosDistritales'
        ]);

        return response()->json([
            'success' => true,
            'data' => $dependencia,
            'message' => 'Dependencia con relaciones completas'
        ], 200);
    }

    public function store(StoreDependenciaRequest $request)
    {
        return app(DependenciaAdminController::class)->store($request);
    }

    public function update(UpdateDependenciaRequest $request, Dependencia $dependencia)
    {
        $dependencia->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $dependencia->fresh(),
            'message' => 'Dependencia actualizada'
        ], 200);
    }

    public function destroy(Dependencia $dependencia)
    {
        $dependencia->checkForRelationships([
            'macroProcesos',
            'gabinetes',
            'perfiles',
            'directoriosDistritales'
        ]);

        $dependencia->forceDelete();
        return response()->noContent();
    }
}
