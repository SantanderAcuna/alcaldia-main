<?php

namespace App\Http\Controllers\api\admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubDireccionAdminController
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = Subdirecion::with('secretaria', 'tramites')
                ->filter($request->only(['nombre']))
                ->orderBy('nombre')
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
            $subdireccion = Subdirecion::with('dependencia')->findOrFail($id);
            return response()->json(['data' => $subdireccion], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Subdirección no encontrada', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $subdireccion = DB::transaction(function () use ($request) {
                $validated = $this->validateSubdireccion($request);
                return Subdirecion::create($validated);
            });

            return response()->json(['data' => $subdireccion, 'message' => 'Subdirección creada'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear la subdirección');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $subdireccion = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateSubdireccion($request, true);
                $subdireccion = Subdirecion::findOrFail($id);
                $subdireccion->update($validated);
                return $subdireccion;
            });

            return response()->json(['data' => $subdireccion, 'message' => 'Subdirección actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar la subdirección');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $subdireccion = Subdirecion::findOrFail($id);
                $subdireccion->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la subdirección');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $subdireccion = Subdirecion::withTrashed()->findOrFail($id);
                $subdireccion->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente la subdirección');
        }
    }

    private function validateSubdireccion(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'dependencia_id' => 'required|exists:dependencias,id',
            'estado' => 'boolean'
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
