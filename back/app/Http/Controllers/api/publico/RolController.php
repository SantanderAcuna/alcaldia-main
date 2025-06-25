<?php

namespace App\Http\Controllers\api\publico;

use App\Models\Rol;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RolController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = Rol::query()
                ->filter($request->only(['name', 'slug']))
                ->orderBy('name')
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
            $rol = Rol::findOrFail($id);
            return response()->json(['data' => $rol], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Rol no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $rol = DB::transaction(function () use ($request) {
                $validated = $this->validateRol($request);
                return Rol::create($validated);
            });

            return response()->json(['data' => $rol, 'message' => 'Rol creado exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el rol');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $rol = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateRol($request, true);
                $rol = Rol::findOrFail($id);
                $rol->update($validated);
                return $rol;
            });

            return response()->json(['data' => $rol, 'message' => 'Rol actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el rol');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $rol = Rol::findOrFail($id);
                $rol->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el rol');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $rol = Rol::withTrashed()->findOrFail($id);
                $rol->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el rol');
        }
    }

    private function validateRol(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'name' => 'required|string|max:50|unique:rols,name' . ($isUpdate ? ',' . $request->route('id') : ''),
            'slug' => 'required|string|max:60|unique:rols,slug' . ($isUpdate ? ',' . $request->route('id') : ''),
            'label' => 'required|string|max:100',
            'is_active' => 'boolean',
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
        return response()->json(['message' => $message, 'error' => config('app.debug') ? debug_backtrace() : null], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
