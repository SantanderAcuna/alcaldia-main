<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Permiso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PermisoAdminController
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = Permiso::query()
                ->filter($request->only(['nombre', 'grupo']))
                ->orderBy('grupo')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();
        return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error al listar: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Error al listar',
                'error'   => $e->getMessage(),     // opcional, para debugging
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $permiso = Permiso::findOrFail($id);
            return response()->json(['data' => $permiso], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Permiso no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $permiso = DB::transaction(function () use ($request) {
                $validated = $this->validatePermiso($request);
                return Permiso::create($validated);
            });

            return response()->json(['data' => $permiso, 'message' => 'Permiso creado exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el permiso');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $permiso = DB::transaction(function () use ($request, $id) {
                $validated = $this->validatePermiso($request, true);
                $permiso = Permiso::findOrFail($id);
                $permiso->update($validated);
                return $permiso;
            });

            return response()->json(['data' => $permiso, 'message' => 'Permiso actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el permiso');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $permiso = Permiso::findOrFail($id);
                $permiso->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el permiso');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $permiso = Permiso::withTrashed()->findOrFail($id);
                $permiso->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el permiso');
        }
    }

    private function validatePermiso(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:255|unique:permisos,nombre' . ($isUpdate ? ',' . $request->route('id') : ''),
            'grupo' => 'required|string|max:50',
            'slug' => 'required|string|max:255',
            'is_active' => 'boolean'
        ];

        if ($isUpdate) {
            foreach ($rules as $key => $rule) {
                $rules[$key] = str_replace('required|', 'sometimes|', $rule);
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
