<?php

namespace App\Http\Controllers\Api\Usuarios\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\StorePerfilRequest;
use App\Http\Requests\Usuario\UpdatePerfilRequest;
use App\Models\Usuario\Perfil;
use Illuminate\Http\Request;

class PerfilSuperAdminController  extends Controller
{
    public function index()
    {
        $perfiles = Perfil::conRelaciones()
            ->paginate(10);

        return response()->json([
            'data' => $perfiles,
            'message' => 'Perfiles públicos obtenidos'
        ], 200);
    }

    public function show(Perfil $perfil){
        return response()->json([
            'data' => $perfil->load(['user', 'dependencia']),
            'message' => 'Detalle completo del perfil'
        ], 200);
    }

    public function store(StorePerfilRequest $request)
    {
        $perfil = Perfil::create($request->validated());
        return response()->json([
            'data' => $perfil,
            'message' => 'Perfil creado exitosamente'
        ], 201);
    }


    public function update(UpdatePerfilRequest $request, Perfil $perfil)
    {
        $perfil->update($request->validated());
        return response()->json([
            'data' => $perfil->fresh(),
            'message' => 'Perfil actualizado'
        ], 200);
    }

    public function destroy(Perfil $perfil)
    {
        $perfil->forceDelete();
        return response()->noContent();
    }
}
