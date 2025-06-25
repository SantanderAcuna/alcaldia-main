<?php

namespace App\Http\Controllers\api\publico;

use Illuminate\Http\Request;

use App\Models\Funcionarios;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DirectorioController
{

    public function index()
    {
        try {
            $data = Funcionarios::with(['secretaria', 'perfil'])
                ->orderByDesc('id')
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
