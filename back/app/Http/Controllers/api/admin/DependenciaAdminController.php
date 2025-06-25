<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Dependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DependenciaAdminController
{
    public function index(Request $request)
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
    }}
