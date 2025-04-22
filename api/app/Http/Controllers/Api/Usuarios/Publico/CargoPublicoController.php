<?php


namespace App\Http\Controllers\Api\Usuarios\Publico;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCargoRequest;
use App\Models\Usuario\Cargo;
use Illuminate\Http\Request;

class CargoPublicoController  extends Controller
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
