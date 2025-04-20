<?php

namespace App\Http\Controllers\Api\Alcaldia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreAlcaldeRequest;
use App\Models\Alcaldia\Alcalde;
use Illuminate\Http\Request;

class AlcaldeAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'tieneRol:admin,editor_alcaldia']);
    }

    public function index()
    {
        $alcaldes = Alcalde::with(['galeria', 'planesDesarrollo'])
            ->whereHas('galeria', fn($q) => $q->where('disco', 'public'))
            ->filter(request(['actual', 'year']))
            ->orderByRaw('fecha_inicio DESC, actual DESC')
            ->paginate(request('per_page', 15))
            ->withQueryString();

        return response()->json([
            'data' => $alcaldes,
            'meta' => [
                'total_actuales' => Alcalde::where('actual', true)->count()
            ]
        ], 200);
    }

    public function show(Alcalde $alcalde)
    {
        return response()->json([
            'data' => $alcalde->loadMissing([
                'galeria.metadatos',
                'planesDesarrollo.galeria'
            ]),
            'message' => 'Detalle completo del alcalde'
        ]);
    }

    public function store(StoreAlcaldeRequest $request)
    {
        $alcalde = Alcalde::create($request->validated());

        if ($request->has('galeria_id')) {
            $alcalde->galeria()->associate($request->galeria_id);
        }

        return response()->json([
            'data' => $alcalde->fresh(['galeria']),
            'message' => 'Alcalde creado exitosamente'
        ], 201);
    }
}
