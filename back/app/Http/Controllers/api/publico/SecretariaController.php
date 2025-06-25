<?php

namespace App\Http\Controllers\api\publico;

use App\Models\Secretaria;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SecretariaController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Secretaria::with(['funciones', 'dependencias', 'tramites', 'funcionarios'])
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
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function errorResponse(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
