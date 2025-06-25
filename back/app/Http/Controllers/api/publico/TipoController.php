<?php

namespace App\Http\Controllers\api\publico;

use App\Models\Tipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TipoController
{

    public function index()
    {
        try {
            $data  = Tipo::orderByDesc('id')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Error al listar',
                'error'   => $e->getMessage(),     // opcional, para debugging
            ], 500);
        }
    }
}
