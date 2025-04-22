<?php

namespace App\Http\Controllers\Api\Usuarios\SuperAdmin;

use App\Http\Controllers\Controller;


use App\Http\Requests\StoreCargoRequest;
use App\Http\Requests\UpdateCargoRequest;
use App\Http\Requests\Usuario\Cargo\UpdateCargoRequest as CargoUpdateCargoRequest;
use App\Models\Usuario\Cargo;
use Illuminate\Http\Request;

class CargoSuperAdminController  extends Controller
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
    public function store(StoreCargoRequest $request)
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

    /**
     * Actualizar un cargo existente
     *
     * @param UpdateCargoRequest $request
     * @param Cargo $cargo
     * @return JsonResponse
     */
    public function update(CargoUpdateCargoRequest $request, Cargo $cargo)
    {
        $cargo->update($request->validated());
        return response()->json($cargo);
    }

    /**
     * Eliminar un cargo
     *
     * @param Cargo $cargo
     * @return JsonResponse
     */
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();
        return response()->json(null, 204);
    }
}
