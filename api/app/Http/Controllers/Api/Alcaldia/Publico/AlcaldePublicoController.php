<?php

namespace App\Http\Controllers\Api\Alcaldia\Publico;

use App\Http\Controllers\Controller;
use App\Models\Alcaldia\Alcalde;
use Illuminate\Http\Request;

class AlcaldePublicoController extends Controller
{
    public function index()
    {
        $alcaldes = Alcalde::conGaleria()
            ->actual()
            ->filter(request(['search', 'cargo']))
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'data' => $alcaldes,
            'message' => 'Alcaldes obtenidos exitosamente'
        ]);
    }

    public function show(Alcalde $alcalde)
    {
        return response()->json([
            'data' => $alcalde->load([
                'galeria',
                'planesDesarrollo' => function ($query) {
                    $query->select('id', 'titulo', 'created_at')
                        ->with('galeria');
                }
            ]),
            'message' => 'Alcalde obtenido exitosamente'
        ]);
    }

}
