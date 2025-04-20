<?php

namespace App\Http\Controllers\Api\Alcaldia\Publico;

use App\Http\Controllers\Controller;
use App\Models\Alcaldia\Area;
use Illuminate\Http\Request;

class AreaPublicoController extends Controller
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
}
