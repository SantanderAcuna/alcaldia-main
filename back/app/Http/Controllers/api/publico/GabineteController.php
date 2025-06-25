<?php

namespace App\Http\Controllers\api\publico;

use App\Models\Gabinete;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class GabineteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = Gabinete::with(['user', 'dependencia', 'perfil'])
                ->orderByDesc('fecha_inicio')
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
            $item = Gabinete::with(['user', 'dependencia', 'perfil'])->findOrFail($id);
            return response()->json(['data' => $item], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Gabinete no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $item = DB::transaction(function () use ($request) {
                $validated = $this->validateGabinete($request);
                return Gabinete::create($validated);
            });

            return response()->json(['data' => $item, 'message' => 'Gabinete creado'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el gabinete');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $item = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateGabinete($request, true);
                $item = Gabinete::findOrFail($id);
                $item->update($validated);
                return $item;
            });

            return response()->json(['data' => $item, 'message' => 'Gabinete actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el gabinete');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $item = Gabinete::findOrFail($id);
                $item->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el gabinete');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $item = Gabinete::withTrashed()->findOrFail($id);
                $item->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el gabinete');
        }
    }

    private function validateGabinete(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'dependencia_id' => 'required|exists:dependencias,id',
            'perfil_id' => 'required|exists:perfils,id',
            'cargo' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'actual' => 'boolean'
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
        return response()->json(['message' => $message], $code);
    }

    private function validationErrorResponse(ValidationException $e): JsonResponse
    {
        return response()->json(['message' => 'Error de validación', 'errors' => $e->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
