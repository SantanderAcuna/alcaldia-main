<?php

namespace App\Http\Controllers\Api\Alcaldia\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreGabineteRequest;
use App\Http\Requests\Alcaldia\UpdateGabineteRequest;
use App\Models\Alcaldia\Gabinete;
use Illuminate\Http\Request;

class GabineteSuperAdminController extends Controller
{
    public function index()
    {
        $gabinetes = Gabinete::actuales()
            ->conRelaciones()
            ->paginate(10);

        return response()->json([
            'data' => $gabinetes,
            'message' => 'Gabinete activo actual'
        ], 200);
    }

    public function show(Gabinete $gabinete)
    {
        return response()->json([
            'data' => $gabinete->load(['user', 'dependencia', 'perfil']),
            'message' => 'Detalle completo del miembro del gabinete'
        ], 200);
    }


    public function store(StoreGabineteRequest $request)
    {
        $gabinete = Gabinete::create($request->validated());
        return response()->json([
            'data' => $gabinete,
            'message' => 'Miembro del gabinete registrado'
        ], 201);
    }

    public function update(UpdateGabineteRequest $request, Gabinete $gabinete)
    {
        $gabinete->update($request->validated());
        return response()->json([
            'data' => $gabinete->fresh(),
            'message' => 'Registro actualizado'
        ], 200);
    }

    public function destroy(Gabinete $gabinete)
    {
        $gabinete->forceDelete();
        return response()->noContent();
    }

    public function restore($id)
    {
        $gabinete = Gabinete::onlyTrashed()->findOrFail($id);
        $gabinete->restore();
        return response()->json([
            'data' => $gabinete,
            'message' => 'Registro restaurado'
        ], 200);
    }
}
