<?php

namespace App\Http\Controllers\Api;

use App\Models\FuncionMacroProceso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class FuncionMacroProcesoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $funciones = FuncionMacroProceso::with(['macroProceso', 'tipoProcedimiento'])
                ->filter($request->only(['macro_proceso_id']))
                ->orderBy('orden')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $funciones], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar funciones: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener las funciones del macroproceso');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $funcion = FuncionMacroProceso::with(['macroProceso', 'tipoProcedimiento'])->findOrFail($id);
            return response()->json(['data' => $funcion], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Función no encontrada', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $funcion = DB::transaction(function () use ($request) {
                $validated = $this->validateFuncion($request);
                return FuncionMacroProceso::create($validated);
            });

            return response()->json(['data' => $funcion, 'message' => 'Función creada'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la función');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $funcion = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateFuncion($request, true);
                $funcion = FuncionMacroProceso::findOrFail($id);
                $funcion->update($validated);
                return $funcion;
            });

            return response()->json(['data' => $funcion, 'message' => 'Función actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la función');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $funcion = FuncionMacroProceso::findOrFail($id);
                $funcion->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la función');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $funcion = FuncionMacroProceso::withTrashed()->findOrFail($id);
                $funcion->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente la función');
        }
    }

    private function validateFuncion(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'macro_proceso_id' => 'required|exists:macro_procesos,id',
            'tipo_procedimiento_id' => 'nullable|exists:tipo_procedimientos,id',
            'descripcion' => 'required|string',
            'orden' => 'nullable|integer'
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
