<?php

namespace App\Http\Controllers\api\publico;


use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PublicacionController
{
    public function index()
    {
        try {
            $data  = Publicacion::with(['fotos', 'documentos'])
                ->orderByDesc('id')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar : ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Error al listar ',
                'error'   => $e->getMessage(),     // opcional, para debugging
            ], 500);
        }
    }
}
