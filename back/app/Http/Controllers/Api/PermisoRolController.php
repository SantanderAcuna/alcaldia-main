<?php

namespace App\Http\Controllers\Api;

use App\Models\PermisoRol;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PermisoRolController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = PermisoRol::with(['rol', 'permiso'])->paginate($request->input('per_page', 15));
            return response()->json(['data' => $data], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('PermisoRol index error: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener las relaciones permiso-rol');
        }
    }

    public function show(int $roleId, int $permisoId): JsonResponse
    {
        try {
            $item = PermisoRol::where('role_id', $roleId)
                ->where('permiso_id', $permisoId)
                ->with(['rol', 'permiso'])
                ->firstOrFail();

            return response()->json(['data' => $item], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Relación no encontrada', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'role_id' => 'required|exists:rols,id',
                'permiso_id' => 'required|exists:permisos,id',
            ]);

            $relacion = PermisoRol::firstOrCreate($data);

            return response()->json(['data' => $relacion, 'message' => 'Relación creada'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la relación');
        }
    }

    public function update(Request $request, int $roleId, int $permisoId): JsonResponse
    {
        try {
            $data = $request->validate([
                'role_id' => 'required|exists:rols,id',
                'permiso_id' => 'required|exists:permisos,id',
            ]);

            $relacion = PermisoRol::where('role_id', $roleId)
                ->where('permiso_id', $permisoId)
                ->firstOrFail();

            $relacion->update($data);

            return response()->json(['data' => $relacion, 'message' => 'Relación actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la relación');
        }
    }

    public function destroy(int $roleId, int $permisoId): JsonResponse
    {
        try {
            PermisoRol::where('role_id', $roleId)
                ->where('permiso_id', $permisoId)
                ->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la relación');
        }
    }

    public function forceDestroy(int $roleId, int $permisoId): JsonResponse
    {
        return $this->destroy($roleId, $permisoId);
    }

    private function errorResponse(string $message, int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json(['message' => $message], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json([
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
