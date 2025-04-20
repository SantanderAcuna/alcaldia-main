<?php

namespace App\Http\Controllers\Api\Alcaldia\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\UpdateAreaRequest;
use App\Models\Alcaldia\Area;
use Illuminate\Http\Request;

class AreaSuperAdminController extends Controller
{
    public function index()
    {
        try {
            $areas = Area::with('subdireccion')->whereHas('subdireccion', fn($q) => $q->where('estado', true))->get();
            return response()->json($areas, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Area $area)
    {
        try {
            return response()->json($area->load('subdireccion'), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreAreaRequest $request)
    {
        try {
            $area = Area::create($request->validated());
            return response()->json($area, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(UpdateAreaRequest $request, Area $area)
    {
        try {
            $area->update($request->validated());
            return response()->json($area, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Area $area)
    {
        try {
            // Validar si tiene relaciones dependientes
            if ($area->empleados()->exists()) {
                return response()->json(['error' => 'Elimine primero los empleados asociados'], 409);
            }

            $area->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
