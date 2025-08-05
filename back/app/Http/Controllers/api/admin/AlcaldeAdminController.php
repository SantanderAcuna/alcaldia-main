<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Alcalde;
use App\Models\PlanDeDesarrollo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AlcaldeAdminController
{
    public function index()
    {
        try {
            $alcaldes = Alcalde::with(['planDesarrollo.documentos'])
                ->orderBy('actual', 'desc')
                ->orderByDesc('fecha_inicio')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $alcaldes
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
     * Mostrar alcalde específico (GET /api/alcaldes/{id})
     */
    public function show(Alcalde $alcalde)
    {
        try {
            // Carga eficiente de relaciones necesarias
            $alcalde->load(['planDesarrollo.documentos']);

            return response()->json([
                'status' => true,
                'data' => $alcalde,
                'meta' => [
                    'last_updated' => $alcalde->updated_at->toIso8601String(),
                    'version' => $alcalde->updated_at->timestamp
                ]
            ]);
        } catch (\Throwable $e) {
            Log::error("Error fetching alcalde #{$alcalde->id}: " . $e->getMessage(), [
                'exception' => $e,
                'request' => request()->all()
            ]);

            return response()->json([
                'status' => false,
                'error' => config('app.debug') ? [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ] : 'Error al recuperar el alcalde'
            ], 500);
        }
    }


    public function store(Request $request)
    {
        $rules = $this->validationRules();
        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            // 1. Crear Alcalde
            $alcalde = Alcalde::create([
                'nombre_completo' => $validated['nombre_completo'],
                'sexo'            => $validated['sexo'],
                'fecha_inicio'    => $validated['fecha_inicio'],
                'fecha_fin'       => $validated['fecha_fin'] ?? null,
                'presentacion'    => $validated['presentacion'] ?? null,
                'foto_path'       => $validated['foto_path'] ?? null,
                'actual'          => $validated['actual'],
            ]);

            // 2. Crear Plan de Desarrollo
            $plan = $this->createOrUpdatePlan($alcalde, $validated['plan']);

            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $alcalde->load('planDesarrollo.documentos'),
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error creating alcalde: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error al crear alcalde',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function update(Request $request, Alcalde $alcalde)
    {
        $rules = $this->validationRules(true);
        $validated = $request->validate($rules);

        try {
            DB::beginTransaction();

            // Actualizar Alcalde
            $alcalde->update([
                'nombre_completo' => $validated['nombre_completo'],
                'sexo'            => $validated['sexo'],
                'fecha_inicio'    => $validated['fecha_inicio'],
                'fecha_fin'       => $validated['fecha_fin'] ?? null,
                'presentacion'    => $validated['presentacion'] ?? null,
                'foto_path'       => $validated['foto_path'] ?? $alcalde->foto_path,
                'actual'          => $validated['actual'],
            ]);

            // Actualizar o crear Plan de Desarrollo
            $this->createOrUpdatePlan($alcalde, $validated['plan']);

            DB::commit();

            return response()->json([
                'status' => true,
                'data'   => $alcalde->fresh('planDesarrollo.documentos')
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Update error: {$e->getMessage()}");
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Método para crear o actualizar el plan de desarrollo
     */
    private function createOrUpdatePlan(Alcalde $alcalde, array $planData): PlanDeDesarrollo
    {
        $plan = $alcalde->planDesarrollo()->firstOrNew();

        $plan->fill([
            'titulo' => $planData['titulo'],
            'descripcion' => $planData['descripcion']
        ])->save();

        // Sincronizar documentos
        if (isset($planData['documentos'])) {
            $plan->documentos()->delete();

            foreach ($planData['documentos'] as $doc) {
                $plan->documentos()->create([
                    'path' => $doc['path'],
                    'nombre' => $doc['nombre']
                ]);
            }
        }

        return $plan;
    }

    /**
     * Reglas de validación unificadas
     */
    protected function validationRules(bool $isUpdate = false): array
    {
        $rules = [
            // Campos del alcalde
            'nombre_completo' => 'required|string|max:150',
            'fecha_inicio'    => 'required|date|before_or_equal:today',
            'fecha_fin'       => 'nullable|date|after_or_equal:fecha_inicio',
            'presentacion'    => 'nullable|string',
            'sexo'            => 'required|in:masculino,femenino,otro',
            'actual'          => 'required|boolean',
            'foto_path'       => 'nullable|string|max:255',

            // Campos del plan de desarrollo
            'plan.titulo'      => 'required|string|max:255',
            'plan.descripcion' => 'required|string',
            'plan.documentos'  => 'required|array|min:1',
            'plan.documentos.*.path' => 'required|string|max:255',
            'plan.documentos.*.nombre' => 'required|string|max:255',
        ];

        // Hacer campos opcionales para actualización
        if ($isUpdate) {
            $rules['plan.documentos'] = 'sometimes|array|min:1';
            $rules['foto_path'] = 'sometimes|nullable|string|max:255';
        }

        return $rules;
    }


    /**
     * Eliminar alcalde (DELETE /api/alcaldes/{id})
     */
    public function destroy(Alcalde $alcalde)
    {
        DB::beginTransaction();
        try {

            $alcalde->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Alcalde eliminado correctamente'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error deleting alcalde: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar alcalde'
            ], 500);
        }
    }
}
