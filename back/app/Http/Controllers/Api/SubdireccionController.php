<?php

namespace App\Http\Controllers\Api;

use App\Models\Subdireccion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class SubdireccionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $subdirecciones = Subdireccion::with('dependencia')
                ->filter($request->only(['nombre']))
                ->orderBy('nombre')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $subdirecciones], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar subdirecciones: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener las subdirecciones');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $subdireccion = Subdireccion::with('dependencia')->findOrFail($id);
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
                return Subdireccion::create($validated);
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
                $subdireccion = Subdireccion::findOrFail($id);
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
                $subdireccion = Subdireccion::findOrFail($id);
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
                $subdireccion = Subdireccion::withTrashed()->findOrFail($id);
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
