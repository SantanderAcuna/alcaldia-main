<?php

namespace App\Http\Controllers\Api\Alcaldia\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\StoreAreaRequest;
use App\Http\Requests\Alcaldia\UpdateAreaRequest;
use App\Models\Alcaldia\Area;
use Illuminate\Http\Request;

class AreaAdminController extends Controller
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


}
