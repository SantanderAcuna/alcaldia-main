<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicacionAdminController
{
    /**
     * Display a listing of the resource.
     */
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
}
