<?php

namespace App\Http\Controllers\Api\Usuarios;

use App\Http\Controllers\Controller;
use App\Models\Usuario\Perfil;
use Illuminate\Http\Request;

class PerfilPublicoController extends Controller
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
}
