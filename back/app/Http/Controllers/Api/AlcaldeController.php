<?php

namespace App\Http\Controllers\Api;

use App\Models\Alcalde;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AlcaldeController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $alcaldes = Alcalde::with(['galeria', 'planesDesarrollo'])
                        ->orderBy('actual', 'DESC')
                        ->orderBy('fecha_inicio', 'DESC')
                        ->get();

            return response()->json([
                'data' => $alcaldes,
                'total_actuales' => Alcalde::where('actual', true)->count()
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            Log::error('Error al listar alcaldes: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener la lista de alcaldes');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $alcalde = Alcalde::with(['galeria.metadatos', 'planesDesarrollo.galeria'])
                        ->findOrFail($id);

            return response()->json([
                'data' => $alcalde,
                'message' => 'Detalle completo del alcalde'
            ], Response::HTTP_OK);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Alcalde no encontrado', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Error al mostrar alcalde ID: $id - " . $e->getMessage());
            return $this->errorResponse('Error al obtener el detalle del alcalde');
        }
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $this->validateAlcalde($request);

            if ($validated['actual']) {
                Alcalde::where('actual', true)->update(['actual' => false]);
            }

            $alcalde = Alcalde::create($validated);

            if (isset($validated['galeria_id'])) {
                $alcalde->galeria()->associate($validated['galeria_id']);
                $alcalde->save();
            }

            DB::commit();
            return response()->json([
                'data' => $alcalde->load('galeria'),
                'message' => 'Alcalde creado exitosamente'
            ], Response::HTTP_CREATED);

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear alcalde: ' . $e->getMessage());
            return $this->errorResponse('Error al crear el alcalde');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validated = $this->validateAlcalde($request, true);

            $alcalde = Alcalde::findOrFail($id);

            if (isset($validated['actual']) && $validated['actual']) {
                Alcalde::where('actual', true)
                    ->where('id', '!=', $id)
                    ->update(['actual' => false]);
            }

            $alcalde->update($validated);

            if (array_key_exists('galeria_id', $validated)) {
                $alcalde->galeria()->associate($validated['galeria_id']);
                $alcalde->save();
            }

            DB::commit();
            return response()->json([
                'data' => $alcalde->fresh(['galeria']),
                'message' => 'Alcalde actualizado exitosamente'
            ], Response::HTTP_OK);

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar alcalde: ' . $e->getMessage());
            return $this->errorResponse('Error al actualizar el alcalde');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $alcalde = Alcalde::findOrFail($id);
            $alcalde->delete();

            DB::commit();
            return response()->json([
                'message' => 'Alcalde eliminado correctamente'
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar alcalde: ' . $e->getMessage());
            return $this->errorResponse('Error al eliminar el alcalde');
        }
    }

    protected function validateAlcalde(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre_completo' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'objetivo' => 'nullable|string',
            'actual' => 'required|boolean',
            'galeria_id' => 'nullable|exists:galerias,id'
        ];

        if ($isUpdate) {
            $rules = array_map(function ($rule) {
                return str_replace('required|', 'sometimes|', $rule);
            }, $rules);
        }

        return $request->validate($rules);
    }

    protected function errorResponse(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code
        ], $code);
    }

    protected function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json([
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
