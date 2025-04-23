<?php

namespace App\Http\Controllers\Api;

use App\Models\Dependencia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DependenciaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $dependencias = Dependencia::query()
                ->filter($request->only(['nombre', 'correo']))
                ->orderBy('nombre')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $dependencias], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar dependencias: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener las dependencias');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $dependencia = Dependencia::findOrFail($id);
            return response()->json(['data' => $dependencia], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Dependencia no encontrada', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $dependencia = DB::transaction(function () use ($request) {
                $validated = $this->validateDependencia($request);
                return Dependencia::create($validated);
            });

            return response()->json(['data' => $dependencia, 'message' => 'Dependencia creada exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la dependencia');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $dependencia = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateDependencia($request, true);
                $dependencia = Dependencia::findOrFail($id);
                $dependencia->update($validated);
                return $dependencia;
            });

            return response()->json(['data' => $dependencia, 'message' => 'Dependencia actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la dependencia');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $dependencia = Dependencia::findOrFail($id);
                $dependencia->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la dependencia');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $dependencia = Dependencia::withTrashed()->findOrFail($id);
                $dependencia->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente la dependencia');
        }
    }

    private function validateDependencia(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:150|unique:dependencias,nombre' . ($isUpdate ? ',' . $request->route('id') : ''),
            'descripcion' => 'nullable|string',
            'correo' => 'nullable|email|max:150',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id'
        ];

        if ($isUpdate) {
            foreach ($rules as $k => $rule) {
                $rules[$k] = str_replace('required|', 'sometimes|', $rule);
            }
        }

        return $request->validate($rules);
    }

    private function errorResponse(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json(['message' => $message, 'error' => config('app.debug') ? debug_backtrace() : null], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
