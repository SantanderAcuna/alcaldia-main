<?php

namespace App\Http\Controllers\Api\Galeria\Publico;

use App\Http\Controllers\Controller;
use App\Models\Galeria;
use Illuminate\Http\Request;

class GaleriaPublicoController extends Controller
{
    public function index()
    {
        $galerias = Galeria::where('disco', 'public')
            ->with('galeriaable')
            ->paginate(12);

        return response()->json([
            'data' => $galerias,
            'message' => 'Galería pública obtenida'
        ], 200);
    }

    public function show(Galeria $galeria)
    {
        return response()->json([
            'data' => $galeria->load('galeriaable'),
            'message' => 'Detalle de archivo'
        ], 200);
    }
}
