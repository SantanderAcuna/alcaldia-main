<?php

namespace App\Http\Controllers\Api\Alcaldia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreSubdireccionRequest;
use App\Models\Alcaldia\Subdireccion;
use Illuminate\Http\Request;

class SubdireccionAdminController extends Controller
{
    public function index()
    {
        try {
            $subdirecciones = Subdireccion::with(['dependencia', 'areas'])
                ->where('estado', true)
                ->get();

            return response()->json($subdirecciones, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Subdireccion $subdireccion)
    {
        try {
            return response()->json($subdireccion->load('areas'), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreSubdireccionRequest $request)
    {
        try {
            $subdireccion = Subdireccion::create($request->validated());
            return response()->json($subdireccion, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
