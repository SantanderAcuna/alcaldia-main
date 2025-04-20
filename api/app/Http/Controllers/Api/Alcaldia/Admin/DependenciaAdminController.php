<?php

namespace App\Http\Controllers\Api\Alcaldia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreDependenciaRequest;
use App\Models\Alcaldia\Dependencia;
use Illuminate\Http\Request;

class DependenciaAdminController extends Controller
{
    public function index()
    {
        $dependencias = Dependencia::with(['responsable', 'macroProcesos'])
            ->advancedFilter()
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $dependencias,
            'meta' => [
                'total_activas' => Dependencia::count(),
                'con_responsable' => Dependencia::has('responsable')->count()
            ]
        ], 200);
    }

    public function show(Dependencia $dependencia)
    {
        return response()->json([
            'success' => true,
            'data' => $dependencia->loadMissing('gabinetes.perfil'),
            'message' => 'Dependencia para administración'
        ], 200);
    }

    public function store(StoreDependenciaRequest $request)
    {
        $dependencia = Dependencia::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $dependencia,
            'message' => 'Dependencia creada exitosamente'
        ], 201);
    }
}
