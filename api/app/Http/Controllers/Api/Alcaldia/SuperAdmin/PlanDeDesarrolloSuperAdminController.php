<?php

namespace App\Http\Controllers\Api\Alcaldia\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StorePlanDeDesarrolloRequest;
use App\Http\Requests\Alcaldia\UpdatePlanDeDesarrolloRequest;
use App\Models\Alcaldia\PlanDeDesarrollo;
use Illuminate\Http\Request;

class PlanDeDesarrolloSuperAdminController extends Controller
{
    public function index()
    {
        $planes = PlanDeDesarrollo::vigentes()
            ->conRelaciones()
            ->paginate(5);

        return response()->json([
            'data' => $planes,
            'message' => 'Planes de desarrollo vigentes'
        ], 200);
    }

    public function show(PlanDeDesarrollo $plan)
    {
        return response()->json([
            'data' => $plan->load(['alcalde.galeria', 'galeria']),
            'message' => 'Detalle completo del plan'
        ], 200);
    }

    public function store(StorePlanDeDesarrolloRequest $request)
    {
        $plan = PlanDeDesarrollo::create($request->validated());
        return response()->json([
            'data' => $plan,
            'message' => 'Plan registrado exitosamente'
        ], 201);
    }

    public function update(UpdatePlanDeDesarrolloRequest $request, PlanDeDesarrollo $plan)
    {
        $plan->update($request->validated());
        return response()->json([
            'data' => $plan->fresh(['alcalde', 'galeria']),
            'message' => 'Plan actualizado'
        ], 200);
    }

    public function destroy(PlanDeDesarrollo $plan)
    {
        $plan->forceDelete();
        return response()->noContent();
    }

    public function restore($id)
    {
        $plan = PlanDeDesarrollo::onlyTrashed()->findOrFail($id);
        $plan->restore();
        return response()->json([
            'data' => $plan,
            'message' => 'Plan restaurado'
        ], 200);
    }
}
