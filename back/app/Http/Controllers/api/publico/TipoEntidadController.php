<?php

namespace App\Http\Controllers\api\publico;

use App\Models\TipoEntidad;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TipoEntidadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = TipoEntidad::query()
                ->filter($request->only(['nombre']))
                ->orderBy('nivel_jerarquico')
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
            $tipo = TipoEntidad::findOrFail($id);
            return response()->json(['data' => $tipo], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Tipo de entidad no encontrado', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener el detalle del tipo de entidad');
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $tipo = DB::transaction(function () use ($request) {
                $validated = $this->validateTipoEntidad($request);
                return TipoEntidad::create($validated);
            });

            return response()->json(['data' => $tipo, 'message' => 'Tipo de entidad creado exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el tipo de entidad');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $tipo = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateTipoEntidad($request, true);
                $tipo = TipoEntidad::findOrFail($id);
                $tipo->update($validated);
                return $tipo;
            });

            return response()->json(['data' => $tipo, 'message' => 'Tipo de entidad actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el tipo de entidad');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $tipo = TipoEntidad::findOrFail($id);
                $tipo->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el tipo de entidad');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $tipo = TipoEntidad::withTrashed()->findOrFail($id);
                $tipo->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el tipo de entidad');
        }
    }

    private function validateTipoEntidad(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:50|unique:tipo_entidads,nombre' . ($isUpdate ? ',' . $request->route('id') : ''),
            'slug' => 'required|string|max:60|unique:tipo_entidads,slug' . ($isUpdate ? ',' . $request->route('id') : ''),
            'descripcion' => 'nullable|string',
            'nivel_jerarquico' => 'required|integer|min:1',
            'activo' => 'required|boolean'
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
