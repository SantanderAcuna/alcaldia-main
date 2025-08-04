<?php

namespace App\Http\Controllers\api\admin;

use App\Models\PlanDeDesarrollo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PlanDesarrolloAdminController
{

    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->input('per_page', 10);
            $page = $request->input('page', 1);

            $query = PlanDeDesarrollo::with(['alcalde', 'documentos'])
                ->orderBy('created_at', 'asc')
                ->orderByDesc('created_at');

            $data = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'status' => true,
                'data'   => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar planes: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'Error al listar planes: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $item = PlanDeDesarrollo::with(['alcalde'])->findOrFail($id);

            return response()->json(['data' => $item], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Plan de desarrollo no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $plan = DB::transaction(function () use ($request) {
                $validated = $this->validatePlan($request);

                $plan = PlanDeDesarrollo::create([
                    'titulo'        => $validated['titulo'],
                    'descripcion'   => $validated['descripcion'] ?? null,
                    'alcalde_id'    => $validated['alcalde_id'],
                    'document_path' => [], // Inicializar como array vacío
                ]);

                // Procesar documentos
                $docs = [];
                foreach ($request->file('documentos') as $file) {
                    $path = $file->store('planes/documentos', 'public');

                    // Guardar nombre original + ruta generada
                    $docs[] = [
                        'nombre' => $file->getClientOriginalName(),  // Nombre original
                        'path'   => $path,                          // Ruta almacenada
                    ];
                }

                $plan->update(['document_path' => $docs]);

                return $plan->fresh();
            });

            return response()->json([
                'data' => $plan,
                'message' => 'Plan de desarrollo creado'
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            Log::error('Store PlanDeDesarrollo: ' . $e->getMessage());
            return $this->errorResponse('Error al crear el plan de desarrollo');
        }
    }

    public function update(Request $request, PlanDeDesarrollo $plan): JsonResponse
    {
        try {
            $updatedPlan = DB::transaction(function () use ($request, $plan) {
                $validated = $this->validatePlan($request, true);

                // Actualizar campos básicos
                $updateData = [
                    'titulo' => $validated['titulo'],
                    'descripcion' => $validated['descripcion'] ?? null,
                    'alcalde_id' => $validated['alcalde_id'],
                ];

                $currentDocs = $plan->document_path ?? [];

                // Procesar eliminación de documentos específicos
                if ($request->filled('documentos_a_eliminar') && is_array($request->documentos_a_eliminar)) {
                    // Ordenar índices de mayor a menor para evitar conflictos
                    rsort($request->documentos_a_eliminar);

                    foreach ($request->documentos_a_eliminar as $index) {
                        if (isset($currentDocs[$index])) {
                            // Eliminar archivo físico
                            Storage::disk('public')->delete($currentDocs[$index]['path']);
                            // Quitar del array
                            unset($currentDocs[$index]);
                        }
                    }
                    $currentDocs = array_values($currentDocs); // Reindexar
                }

                // Procesar nuevos documentos
                if ($request->hasFile('documentos')) {
                    foreach ($request->file('documentos') as $file) {
                        $path = $file->store('planes/documentos', 'public');
                        $currentDocs[] = [
                            'nombre' => $file->getClientOriginalName(),
                            'path' => $path,
                        ];
                    }
                }

                // Actualizar paths de documentos
                $updateData['document_path'] = $currentDocs;

                // Actualizar el plan
                $plan->update($updateData);

                return $plan->fresh();
            });

            return response()->json([
                'data' => $updatedPlan,
                'message' => 'Plan de desarrollo actualizado correctamente'
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            Log::error('Update PlanDeDesarrollo ID ' . $plan->id . ': ' . $e->getMessage());
            return $this->errorResponse('Error al actualizar el plan de desarrollo');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                /** @var PlanDeDesarrollo $plan */
                $plan = PlanDeDesarrollo::findOrFail($id);

                // Eliminar archivos físicos
                foreach ($plan->document_path ?? [] as $file) {
                    Storage::disk('public')->delete($file['path']);
                }

                $plan->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            Log::error('Destroy PlanDeDesarrollo: ' . $e->getMessage());
            return $this->errorResponse('Error al eliminar el plan de desarrollo');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                /** @var PlanDeDesarrollo $plan */
                $plan = PlanDeDesarrollo::withTrashed()->findOrFail($id);

                foreach ($plan->document_path ?? [] as $file) {
                    Storage::disk('public')->delete($file['path']);
                }

                $plan->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            Log::error('ForceDestroy PlanDeDesarrollo: ' . $e->getMessage());
            return $this->errorResponse('Error al eliminar permanentemente el plan de desarrollo');
        }
    }

    private function validatePlan(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'titulo'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'alcalde_id'   => ['required', Rule::exists('alcaldes', 'id')],
            'documentos'   => $isUpdate ? 'sometimes|array|min:1' : 'required|array|min:1',
            'documentos.*' => 'file|max:220480',


        ];

        if ($isUpdate) {
            // Hacer todos los campos opcionales para actualización
            foreach ($rules as $field => $rule) {
                $rules[$field] = str_replace('required|', 'sometimes|', $rule);
            }

            // Agregar validación para documentos_a_eliminar
            $rules['documentos_a_eliminar'] = 'sometimes|array';
            $rules['documentos_a_eliminar.*'] = 'integer|min:0';
        }

        return $request->validate($rules);
    }
    /* ════════════════════════════════
     |  HELPERS de respuesta
     ════════════════════════════════*/
    private function errorResponse(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json(
            ['message' => 'Error de validación', 'errors' => $e->errors()],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
