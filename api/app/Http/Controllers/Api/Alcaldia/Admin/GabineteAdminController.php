<?php

namespace App\Http\Controllers\Api\Alcaldia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreGabineteRequest;
use App\Models\Alcaldia\Gabinete;
use Illuminate\Http\Request;

class GabineteAdminController extends Controller
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


    
}
