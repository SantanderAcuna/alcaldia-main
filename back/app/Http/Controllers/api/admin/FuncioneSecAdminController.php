<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Funcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FuncioneSecAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Funcion::with(['secretaria'])
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

}
