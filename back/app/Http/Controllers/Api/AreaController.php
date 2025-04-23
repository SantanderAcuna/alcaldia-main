<?php

namespace App\Http\Controllers\Api;

use App\Models\Area;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AreaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $areas = Area::with(['user', 'parent'])
                ->filter($request->only(['nombre']))
                ->orderBy('nombre')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $areas], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar áreas: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener las áreas');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $area = Area::with(['user', 'parent'])->findOrFail($id);
            return response()->json(['data' => $area], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Área no encontrada', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $area = DB::transaction(function () use ($request) {
                $validated = $this->validateArea($request);
                return Area::create($validated);
            });

            return response()->json(['data' => $area, 'message' => 'Área creada'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el área');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $area = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateArea($request, true);
                $area = Area::findOrFail($id);
                $area->update($validated);
                return $area;
            });

            return response()->json(['data' => $area, 'message' => 'Área actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el área');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $area = Area::findOrFail($id);
                $area->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el área');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $area = Area::withTrashed()->findOrFail($id);
                $area->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el área');
        }
    }

    private function validateArea(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:150|unique:areas,nombre' . ($isUpdate ? ',' . $request->route('id') : ''),
            'area_id' => 'nullable|exists:areas,id',
            'user_id' => 'required|exists:users,id',
            'is_lider' => 'boolean'
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
        return response()->json(['message' => $message], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
