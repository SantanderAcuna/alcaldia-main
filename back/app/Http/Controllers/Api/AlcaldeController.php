<?php

namespace App\Http\Controllers\Api;

use App\Models\Alcalde;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlcaldeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $alcaldes = Alcalde::with(['foto', 'planDesarrollo'])
                ->orderByDesc('actual')
                ->orderByDesc('fecha_inicio')
                ->get();

            return response()->json([
                'data' => $alcaldes,
                'total_actuales' => Alcalde::where('actual', true)->count()
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->errorResponse('Error al obtener la lista de alcaldes', $e);
        }
    }

    public function show(Alcalde $alcalde): JsonResponse
    {
        try {
            $alcalde->load(['foto', 'planDesarrollo']);
            return response()->json([
                'success' => true,
                'data' => $alcalde,
                'message' => 'Detalle del alcalde obtenido correctamente'
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            return $this->errorResponse('Error al obtener el detalle del alcalde', $e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'nombre_completo' => 'required|string|max:150',
                'cargo' => 'required|string|max:200',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date|after:fecha_inicio',
                'actual' => 'required|boolean',
                'foto_id' => 'nullable|exists:galerias,id',
                'plan_desarrollo_id' => 'nullable|exists:galerias,id',
                'objetivo' => 'nullable|string'
            ]);

            if ($validated['actual'] && Alcalde::where('actual', true)->exists()) {
                throw new \Exception('Ya existe un alcalde actual activo');
            }

            $alcalde = Alcalde::create($validated);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $alcalde->load('foto'),
                'message' => 'Alcalde creado exitosamente'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->errorResponse('Error al crear el alcalde', $e);
        }
    }

    public function update(Request $request, Alcalde $alcalde): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'nombre_completo' => 'sometimes|required|string|max:150',
                'cargo' => 'sometimes|required|string|max:200',
                'fecha_inicio' => 'sometimes|required|date',
                'fecha_fin' => 'nullable|date|after:fecha_inicio',
                'actual' => 'sometimes|required|boolean',
                'foto_id' => 'nullable|exists:galerias,id',
                'plan_desarrollo_id' => 'nullable|exists:galerias,id',
                'objetivo' => 'nullable|string'
            ]);

            if (isset($validated['actual']) && $validated['actual']) {
                Alcalde::where('actual', true)->where('id', '!=', $alcalde->id)->update(['actual' => false]);
            }

            $alcalde->update($validated);

            DB::commit();
            return response()->json([
                'data' => $alcalde->fresh(['foto']),
                'message' => 'Alcalde actualizado exitosamente'
            ], Response::HTTP_OK);
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->errorResponse('Error al actualizar el alcalde', $e);
        }
    }

    public function destroy(Alcalde $alcalde): JsonResponse
    {
        DB::beginTransaction();
        try {
            $alcalde->delete();
            DB::commit();
            return response()->json(['message' => 'Alcalde eliminado correctamente']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->errorResponse('Error al eliminar el alcalde', $e);
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $alcalde = Alcalde::withTrashed()->findOrFail($id);
            $alcalde->forceDelete();
            return response()->json(['message' => 'Alcalde eliminado permanentemente']);
        } catch (\Throwable $e) {
            return $this->errorResponse('Error al eliminar definitivamente el alcalde', $e);
        }
    }

    private function errorResponse(string $message, \Throwable $e): JsonResponse
    {
        Log::error("$message: {$e->getMessage()}");

        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => config('app.debug') ? $e->getMessage() : null
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
