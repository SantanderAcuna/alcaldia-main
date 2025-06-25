<?php

namespace App\Http\Controllers\api\publico;

use App\Models\Dependencia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DependenciaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = Dependencia::with('secretaria', 'tramites')

                ->orderBy('nombre')
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
