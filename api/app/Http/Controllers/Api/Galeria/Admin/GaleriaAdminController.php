<?php

namespace App\Http\Controllers\Api\Galeria\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Galeria\StoreGaleriaRequest;
use App\Models\Galeria;
use Illuminate\Http\Request;

class GaleriaAdminController extends Controller
{
    public function index()
    {
        $galerias = Galeria::with('galeriaable')
            ->latest()
            ->paginate(25);

        return response()->json([
            'data' => $galerias,
            'meta' => [
                'total' => Galeria::count()
            ]
        ], 200);
    }

    public function store(StoreGaleriaRequest $request)
    {
        $galeria = Galeria::create($request->validated());
        return response()->json([
            'data' => $galeria,
            'message' => 'Archivo subido exitosamente'
        ], 201);
    }

    public function show(Galeria $galeria)
    {
        return response()->json([
            'data' => $galeria,
            'message' => 'Detalle administrativo'
        ], 200);
    }
}
