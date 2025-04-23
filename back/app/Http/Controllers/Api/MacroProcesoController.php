<?php

namespace App\Http\Controllers\Api;

use App\Models\MacroProceso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class MacroProcesoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $procesos = MacroProceso::with('dependencia')
                ->filter($request->only(['nombre', 'codigo']))
                ->orderBy('nombre')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $procesos], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar macroprocesos: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener los macroprocesos');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $proceso = MacroProceso::with('dependencia')->findOrFail($id);
            return response()->json(['data' => $proceso], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Macroproceso no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $proceso = DB::transaction(function () use ($request) {
                $validated = $this->validateProceso($request);
                return MacroProceso::create($validated);
            });

            return response()->json(['data' => $proceso, 'message' => 'Macroproceso creado'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear macroproceso');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $proceso = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateProceso($request, true);
                $proceso = MacroProceso::findOrFail($id);
                $proceso->update($validated);
                return $proceso;
            });

            return response()->json(['data' => $proceso, 'message' => 'Macroproceso actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar macroproceso');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $proceso = MacroProceso::findOrFail($id);
                $proceso->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar macroproceso');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $proceso = MacroProceso::withTrashed()->findOrFail($id);
                $proceso->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el macroproceso');
        }
    }

    private function validateProceso(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:150|unique:macro_procesos,nombre' . ($isUpdate ? ',' . $request->route('id') : ''),
            'mision' => 'required|string',
            'vision' => 'nullable|string',
            'dependencia_id' => 'required|exists:dependencias,id',
            'codigo' => 'nullable|string|max:50|unique:macro_procesos,codigo' . ($isUpdate ? ',' . $request->route('id') : ''),
            'organigrama_url' => 'nullable|string|max:500',
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
