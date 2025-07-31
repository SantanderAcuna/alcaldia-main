<?php

namespace App\Http\Controllers\api\publico;

use App\Models\Alcalde;
use App\Models\PlanDesarrollo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AlcaldeController extends Controller
{
    /* ========== MÉTODOS PRINCIPALES ========== */

    /**
     * Listar alcaldes (GET /api/alcaldes)
     */
    public function index()
    {
        try {
            $alcaldes = Alcalde::with(['planDesarrollo.documentos'])
                ->orderBy('actual', 'Asc')
                ->orderByDesc('fecha_inicio')
                ->get();

            return response()->json([
                'status' => true,
                'data' => $alcaldes
            ]);
        } catch (\Throwable $e) {
            Log::error("Error listing: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error al listar'
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


    /**
     * Crear alcalde (POST /api/alcaldes)
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate($this->validationRules());
            $filePaths = $this->processFiles($request);

            $alcalde = Alcalde::create([
                'nombre_completo' => $validated['nombre_completo'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'] ?? null,
                'presentacion' => $validated['presentacion'] ?? null,
                'foto_path' => $filePaths['foto_path'],
                'actual' => $validated['actual']
            ]);

            $alcalde->planDesarrollo()->create([
                'titulo' => $validated['titulo'],
                'descripcion' => $validated['descripcion'] ?? null,
                'document_path' => $filePaths['document_path']
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $alcalde->load('planDesarrollo')
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error creating alcalde: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error al crear alcalde'
            ], 500);
        }
    }

    /**
     * Actualizar alcalde (PUT /api/alcaldes/{id})
     */
    public function update(Request $request, Alcalde $alcalde)
    {
        DB::beginTransaction();
        try {
            // 1. Validación estricta
            $validated = $request->validate([
                'nombre_completo' => 'required|string|max:150',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'presentacion' => 'nullable|string|max:15000',
                'actual' => 'required|boolean',
                'titulo' => 'required|string|max:255', // Campo de plan_desarrollo
                'foto_path' => 'sometimes|image|mimes:jpeg,png,webp|max:2048',
                'document_path' => 'sometimes|file|mimes:pdf,doc,docx|max:5120'
            ]);

            // 2. Procesamiento de archivos
            $filePaths = [];
            if ($request->hasFile('foto_path')) {
                $filePaths['foto_path'] = $request->file('foto_path')
                    ->store('alcaldes/fotos', 'public');
                if ($alcalde->foto_path) {
                    Storage::disk('public')->delete($alcalde->foto_path);
                }
            }

            if ($request->hasFile('document_path')) {
                $filePaths['document_path'] = $request->file('document_path')
                    ->store('planes/documentos', 'public');
                if ($alcalde->planDesarrollo?->document_path) {
                    Storage::disk('public')->delete($alcalde->planDesarrollo->document_path);
                }
            }

            // 3. Actualización atómica
            $alcalde->update([
                'nombre_completo' => $validated['nombre_completo'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'],
                'presentacion' => $validated['presentacion'],
                'foto_path' => $filePaths['foto_path'] ?? $alcalde->foto_path,
                'actual' => $validated['actual']
            ]);

            // 4. Actualizar relación
            $alcalde->planDesarrollo()->updateOrCreate(
                ['alcalde_id' => $alcalde->id],
                [
                    'titulo' => $validated['titulo'],
                    'document_path' => $filePaths['document_path'] ?? $alcalde->planDesarrollo?->document_path
                ]
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'data' => $alcalde->fresh('planDesarrollo')
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Update error: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error al actualizar'
            ], 500);
        }
    }

    /**
     * Eliminar alcalde (DELETE /api/alcaldes/{id})
     */
    public function destroy(Alcalde $alcalde)
    {
        DB::beginTransaction();
        try {
            if ($alcalde->foto_path) {
                Storage::disk('public')->delete($alcalde->foto_path);
            }

            if ($plan = $alcalde->planDesarrollo) {

                if ($plan->document_path) {
                    Storage::disk('public')->delete($plan->document_path);
                }
                $plan->delete();
            }
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

    /* ========== MÉTODOS AUXILIARES ========== */

    /**
     * Reglas de validación centralizadas
     */

    public function toArray($request)
    {
        return [
            'fecha_inicio' => $request->fecha_inicio->format('Y-m-d'),
            'fecha_fin' => $request->fecha_fin?->format('Y-m-d'),

        ];
    }


    protected function validationRules(bool $isUpdate = false): array
    {
        return [
            // Campos de tabla 'alcaldes'
            'nombre_completo' => 'required|string|max:150',
            'fecha_inicio' => 'required|date|before_or_equal:today',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'presentacion' => 'nullable|string|max:15000',
            'actual' => 'required|boolean',

            // Campos de tabla 'plan_de_desarrollos'
            'titulo' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:5000',

            // Archivos
            'foto_path' => $isUpdate ?
                'sometimes|image|mimes:jpeg,png,webp|max:2048' :
                'required|image|mimes:jpeg,png,webp|max:2048',
            'document_path' => $isUpdate ?
                'sometimes|file|mimes:pdf,doc,docx|max:5120' :
                'required|file|mimes:pdf,doc,docx|max:5120'
        ];
    }

    /**
     * Procesamiento seguro de archivos
     */
    private function processFiles(Request $request, ?Alcalde $alcalde = null): array
    {
        $paths = [];

        // Procesar foto
        if ($request->hasFile('foto_path')) {
            $paths['foto_path'] = $request->file('foto_path')
                ->store('alcaldes/fotos', 'public');

            if ($alcalde?->foto_path) {
                Storage::disk('public')->delete($alcalde->foto_path);
            }
        }

        // Procesar documento
        if ($request->hasFile('document_path')) {
            $paths['document_path'] = $request->file('document_path')
                ->store('planes/documentos', 'public');

            if ($alcalde?->planDesarrollo?->document_path) {
                Storage::disk('public')->delete($alcalde->planDesarrollo->document_path);
            }
        }

        return $paths;
    }
}
