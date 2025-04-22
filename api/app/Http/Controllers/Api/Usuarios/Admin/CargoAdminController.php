<?php

namespace App\Http\Controllers\Api\Usuarios\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCargoRequest;
use App\Http\Requests\Usuario\Cargo\StoreCargoRequest as CargoStoreCargoRequest;
use App\Models\Usuario\Cargo;
use Illuminate\Http\Request;

class CargoAdminController extends Controller
{
         /**
     * Listar todos los cargos con sus relaciones
     *
     * @return JsonResponse
     */
    public function index()
    {
        $cargos = Cargo::with(['area', 'user'])->get();
        return response()->json($cargos);
    }

    /**
     * Crear un nuevo cargo
     *
     * @param StoreCargoRequest $request
     * @return JsonResponse
     */
    public function store(CargoStoreCargoRequest $request)
    {
        $cargo = Cargo::create($request->validated());
        return response()->json($cargo, 201);
    }

    /**
     * Mostrar un cargo específico
     *
     * @param Cargo $cargo
     * @return JsonResponse
     */
    public function show(Cargo $cargo)
    {
        $cargo->load(['area', 'user']);
        return response()->json($cargo);
    }
}
