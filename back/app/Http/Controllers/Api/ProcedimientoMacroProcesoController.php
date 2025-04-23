<?php

namespace App\Http\Controllers\Api;

use App\Models\ProcedimientoMacroProceso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ProcedimientoMacroProcesoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $items = ProcedimientoMacroProceso::with(['macroProceso', 'tipoProcedimiento', 'funcionMacroProceso'])
                ->filter($request->only(['macro_proceso_id']))
                ->orderBy('orden')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $items], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar procedimientos macroprocesos: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener los procedimientos');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $item = ProcedimientoMacroProceso::with(['macroProceso', 'tipoProcedimiento', 'funcionMacroProceso'])->findOrFail($id);
            return response()->json(['data' => $item], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Procedimiento no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $item = DB::transaction(function () use ($request) {
                $validated = $this->validateProcedimiento($request);
                return ProcedimientoMacroProceso::create($validated);
            });

            return response()->json(['data' => $item, 'message' => 'Procedimiento creado'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el procedimiento');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $item = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateProcedimiento($request, true);
                $item = ProcedimientoMacroProceso::findOrFail($id);
                $item->update($validated);
                return $item;
            });

            return response()->json(['data' => $item, 'message' => 'Procedimiento actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el procedimiento');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $item = ProcedimientoMacroProceso::findOrFail($id);
                $item->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el procedimiento');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $item = ProcedimientoMacroProceso::withTrashed()->findOrFail($id);
                $item->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el procedimiento');
        }
    }

    private function validateProcedimiento(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'macro_proceso_id' => 'required|exists:macro_procesos,id',
            'tipo_procedimiento_id' => 'nullable|exists:tipo_procedimientos,id',
            'funcion_macro_proceso_id' => 'nullable|exists:funcion_macro_procesos,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'nullable|integer',
            'estado' => 'boolean'
        ];

        if ($isUpdate) {
            foreach ($rules as $k => $r) {
                $rules[$k] = str_replace('required|', 'sometimes|', $r);
            }
        }

        return $request->validate($rules);
    }

    private function errorResponse(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'error' => config('app.debug') ? debug_backtrace() : null
        ], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json([
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
