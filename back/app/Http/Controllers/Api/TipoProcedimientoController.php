<?php

namespace App\Http\Controllers\Api;

use App\Models\TipoProcedimiento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TipoProcedimientoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $items = TipoProcedimiento::query()
                ->filter($request->only(['nombre']))
                ->orderBy('nombre')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $items], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar tipos de procedimiento: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener los tipos de procedimiento');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $item = TipoProcedimiento::findOrFail($id);
            return response()->json(['data' => $item], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Tipo de procedimiento no encontrado', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener el detalle del tipo de procedimiento');
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $item = DB::transaction(function () use ($request) {
                $validated = $this->validateTipo($request);
                return TipoProcedimiento::create($validated);
            });

            return response()->json(['data' => $item, 'message' => 'Tipo de procedimiento creado'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el tipo de procedimiento');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $item = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateTipo($request, true);
                $item = TipoProcedimiento::findOrFail($id);
                $item->update($validated);
                return $item;
            });

            return response()->json(['data' => $item, 'message' => 'Tipo de procedimiento actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el tipo de procedimiento');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $item = TipoProcedimiento::findOrFail($id);
                $item->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el tipo de procedimiento');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $item = TipoProcedimiento::withTrashed()->findOrFail($id);
                $item->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el tipo de procedimiento');
        }
    }

    private function validateTipo(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:100|unique:tipo_procedimientos,nombre' . ($isUpdate ? ',' . $request->route('id') : ''),
            'descripcion' => 'nullable|string',
            'estado' => 'boolean'
        ];

        if ($isUpdate) {
            foreach ($rules as $k => $v) {
                $rules[$k] = str_replace('required|', 'sometimes|', $v);
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
