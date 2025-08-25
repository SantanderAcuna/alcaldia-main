<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Dependencia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DependenciaAdminController
{
    public function index()
    {
        $data = Dependencia::with([
            'parent:id,nombre',
            'children:id,nombre,dependencia_padre_id',
            'funcionarios' => fn($q) => $q
                ->select('id', 'nombres', 'apellidos', 'cargo_id', 'dependencia_id', 'genero', 'departamento', 'municipio', 'estado')
                ->with('cargo:id,cargo,nivel,grado'),
            'competencias:id,competencia,orden,dependencia_id',
            'tramites:id,tramite,tramite,codigo,descripcion,dependencia_id',
            'macroprocesos' => fn($q) => $q
                ->select('id', 'macrop', 'dependencia_id', 'codigo', 'descripcion')
                ->with('procesos:id,proceso,codigo,descripcion,macroproceso_id')
        ])
            ->select('id', 'nombre', 'tipo', 'dependencia_padre_id', 'descripcion', 'mision', 'vision', 'organigrama')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:dependencias',
            'codigo' => 'nullable|string|max:20|unique:dependencias',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:SECRETARIA,DEPENDENCIA,SUB_DEPENDENCIA',
            'dependencia_padre_id' => 'nullable|exists:dependencias,id',
            'mision' => 'required|string',
            'vision' => 'required|string',
        ]);

        $dependencia = Dependencia::create($validated);

        return response()->json([
            'status' => true,
            'data' => $dependencia
        ], 201);
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
    public function destroy(Dependencia $secretaria)
    {
        DB::beginTransaction();
        try {
            $secretaria->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Secretaria eliminada correctamente'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error deleting secretaria: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar secretaria'
            ]);
        }
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
