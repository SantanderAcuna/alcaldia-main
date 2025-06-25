<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Dependencia;
use App\Models\Funcionarios;
use App\Models\Secretaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FuncionarioAdminController
{



    public function index()
{
    try {
        // Carga las relaciones necesarias
        $funcionarios = Funcionarios::with([
            'asignacion.organizacion',
            'Secretaria',
            'Perfil'
        ])->get();

        // Formatea la respuesta
        return response()->json([
            'status' => true,
            'data' => $funcionarios->map(function ($funcionario) {
                return [
                    'id' => $funcionario->id,
                    'nombre' => $funcionario->nombres.' '.$funcionario->apellidos,
                    'organizacion' => $funcionario->organizacion,
                    'secretaria' => $funcionario->Secretaria,
                    'perfil' => $funcionario->Perfil
                ];
            })
        ]);

    } catch (\Exception $e) {
        Log::error('Error al listar: '.$e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Error al listar',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $secretarias = Secretaria::all(['id', 'nombre']);
            $dependencias = Dependencia::all(['id', 'nombre']);

            return response()->json([
                'status' => true,
                'data' => [
                    'secretarias' => $secretarias,
                    'dependencias' => $dependencias
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error al cargar datos para crear funcionario: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al cargar datos del formulario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'tipo_rol' => 'required|in:secretario,director,empleado',
                'tipo_organizacion' => 'required|in:secretaria,dependencia',
                'organizacion_id' => 'required|integer'
            ]);

            // Crear Funcionarios
            $Funcionarios = Funcionarios::create([
                'nombre' => $validated['nombre'],
                'tipo_rol' => $validated['tipo_rol']
            ]);

            // Determinar el tipo de organización
            $organizacionType = $validated['tipo_organizacion'] === 'secretaria'
                ? Secretaria::class
                : Dependencia::class;

            // Crear asignación
            $asignacion = $Funcionarios->asignacion()->create([
                'organizacion_id' => $validated['organizacion_id'],
                'organizacion_type' => $organizacionType
            ]);

            // Cargar relaciones para la respuesta
            $Funcionarios->load('asignacion.organizacion');

            return response()->json([
                'status' => true,
                'message' => 'Funcionarios creado exitosamente',
                'data' => $Funcionarios
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al crear Funcionarios: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al crear Funcionarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $Funcionarios = Funcionarios::with(['asignacion.organizacion'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $Funcionarios
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Funcionarios no encontrado'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error al mostrar Funcionarios: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al mostrar Funcionarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $Funcionarios = Funcionarios::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'tipo_rol' => 'sometimes|in:secretario,director,empleado',
                'tipo_organizacion' => 'sometimes|in:secretaria,dependencia',
                'organizacion_id' => 'sometimes|integer'
            ]);

            // Actualizar datos básicos
            $Funcionarios->update($request->only(['nombre', 'tipo_rol']));

            // Actualizar asignación si se proporciona
            if ($request->has('tipo_organizacion') && $request->has('organizacion_id')) {
                $organizacionType = $validated['tipo_organizacion'] === 'secretaria'
                    ? Secretaria::class
                    : Dependencia::class;

                $Funcionarios->asignacion()->updateOrCreate(
                    ['Funcionarios_id' => $Funcionarios->id],
                    [
                        'organizacion_id' => $validated['organizacion_id'],
                        'organizacion_type' => $organizacionType
                    ]
                );
            }

            $Funcionarios->refresh()->load('asignacion.organizacion');

            return response()->json([
                'status' => true,
                'message' => 'Funcionarios actualizado exitosamente',
                'data' => $Funcionarios
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Funcionarios no encontrado'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error al actualizar Funcionarios: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar Funcionarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $Funcionarios = Funcionarios::findOrFail($id);
            $Funcionarios->delete();

            return response()->json([
                'status' => true,
                'message' => 'Funcionarios eliminado exitosamente'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Funcionarios no encontrado'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error al eliminar Funcionarios: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar Funcionarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener organizaciones por tipo (para select dinámico)
     */
    public function getOrganizaciones(Request $request)
    {
        try {
            $request->validate([
                'tipo' => 'required|in:secretaria,dependencia'
            ]);

            if ($request->tipo === 'secretaria') {
                $organizaciones = Secretaria::all(['id', 'nombre as text']);
            } else {
                $organizaciones = Dependencia::all(['id', 'nombre as text']);
            }

            return response()->json([
                'status' => true,
                'data' => $organizaciones
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al obtener organizaciones: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Error al obtener organizaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
