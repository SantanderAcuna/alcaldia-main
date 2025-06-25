<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Perfil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PerfilAdminController
{
    public function index()
    {
        try {
            $data = Perfil::orderBy('id', 'asc')
                ->get();
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
            $perfil = Perfil::with(['user', 'dependencia'])->findOrFail($id);
            return response()->json(['data' => $perfil], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Perfil no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $perfil = DB::transaction(function () use ($request) {
                $validated = $this->validatePerfil($request);
                return Perfil::create($validated);
            });

            return response()->json(['data' => $perfil, 'message' => 'Perfil creado exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el perfil');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $perfil = DB::transaction(function () use ($request, $id) {
                $validated = $this->validatePerfil($request, true);
                $perfil = Perfil::findOrFail($id);
                $perfil->update($validated);
                return $perfil;
            });

            return response()->json(['data' => $perfil, 'message' => 'Perfil actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el perfil');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $perfil = Perfil::findOrFail($id);
                $perfil->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el perfil');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $perfil = Perfil::withTrashed()->findOrFail($id);
                $perfil->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el perfil');
        }
    }

    private function validatePerfil(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'dependencia_id' => 'nullable|exists:dependencias,id',
            'titulo_profesional' => 'nullable|string|max:255',
            'especializacion' => 'nullable|string|max:255',
            'doctorado' => 'nullable|string|max:255',
            'foto_url' => 'nullable|string|max:500',
            'resumen_biografico' => 'nullable|string',
            'experiencia_publica' => 'nullable|json',
        ];

        if ($isUpdate) {
            foreach ($rules as $key => $value) {
                $rules[$key] = str_replace('required|', 'sometimes|', $value);
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
