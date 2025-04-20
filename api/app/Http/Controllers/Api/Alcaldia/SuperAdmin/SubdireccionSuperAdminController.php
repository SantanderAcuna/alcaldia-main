<?php

namespace App\Http\Controllers\Api\Alcaldia\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreSubdireccionRequest;
use App\Http\Requests\Alcaldia\UpdateSubdireccionRequest;
use App\Models\Alcaldia\Subdireccion;
use Illuminate\Http\Request;

class SubdireccionSuperAdminController extends Controller
{

    public function store(StoreSubdireccionRequest $request)
    {
        try {
            $subdireccion = Subdireccion::create($request->validated());
            return response()->json($subdireccion, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function update(UpdateSubdireccionRequest $request, Subdireccion $subdireccion)
    {
        try {
            $subdireccion->update($request->validated());
            return response()->json($subdireccion, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Subdireccion $subdireccion)
    {
        try {
            if ($subdireccion->areas()->exists()) {
                return response()->json([
                    'error' => 'Elimine primero las áreas asociadas'
                ], 409);
            }

            $subdireccion->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
