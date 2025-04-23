<?php

namespace App\Http\Controllers\Api;

use App\Models\RolUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class RolUserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = RolUser::with(['rol', 'user'])
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar relaciones rol-usuario: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener relaciones rol-usuario');
        }
    }

    public function show(int $roleId, int $userId): JsonResponse
    {
        try {
            $item = RoleUser::with(['rol', 'user'])
                ->where('role_id', $roleId)
                ->where('user_id', $userId)
                ->firstOrFail();

            return response()->json(['data' => $item], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Relación no encontrada', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $relacion = DB::transaction(function () use ($request) {
                $data = $this->validateData($request);
                return RoleUser::firstOrCreate($data);
            });

            return response()->json(['data' => $relacion, 'message' => 'Relación creada'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la relación');
        }
    }

    public function update(Request $request, int $roleId, int $userId): JsonResponse
    {
        try {
            $relacion = DB::transaction(function () use ($request, $roleId, $userId) {
                $data = $this->validateData($request);
                $relacion = RoleUser::where('role_id', $roleId)->where('user_id', $userId)->firstOrFail();
                $relacion->update($data);
                return $relacion;
            });

            return response()->json(['data' => $relacion, 'message' => 'Relación actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la relación');
        }
    }

    public function destroy(int $roleId, int $userId): JsonResponse
    {
        try {
            DB::transaction(function () use ($roleId, $userId) {
                RoleUser::where('role_id', $roleId)->where('user_id', $userId)->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la relación');
        }
    }

    public function forceDestroy(int $roleId, int $userId): JsonResponse
    {
        return $this->destroy($roleId, $userId); // No hay softDeletes en pivot por defecto
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'role_id' => 'required|exists:rols,id',
            'user_id' => 'required|exists:users,id',
        ]);
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
