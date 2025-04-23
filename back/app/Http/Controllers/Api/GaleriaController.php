<?php

namespace App\Http\Controllers\Api;

use App\Models\Galeria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class GaleriaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $galerias = Galeria::with('galeriaable')
                ->filter($request->only(['disco']))
                ->orderByDesc('created_at')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $galerias], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar galerías: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener las galerías');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $galeria = Galeria::with('galeriaable')->findOrFail($id);
            return response()->json(['data' => $galeria], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Galería no encontrada', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Error al mostrar galería ID: $id");
            return $this->errorResponse('Error al obtener el detalle de la galería');
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $galeria = DB::transaction(function () use ($request) {
                $validated = $this->validateGaleria($request);
                $galeria = Galeria::create($validated);

                if (!empty($validated['galeriaable_id']) && !empty($validated['galeriaable_type'])) {
                    $galeria->galeriaable_id = $validated['galeriaable_id'];
                    $galeria->galeriaable_type = $validated['galeriaable_type'];
                    $galeria->save();
                }

                return $galeria;
            });

            return response()->json(['data' => $galeria->fresh('galeriaable'), 'message' => 'Galería creada exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            Log::error('Error al crear galería: ' . $e->getMessage());
            return $this->errorResponse('Error al crear la galería');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $galeria = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateGaleria($request, true);
                $galeria = Galeria::findOrFail($id);
                $galeria->update($validated);

                if (!empty($validated['galeriaable_id']) && !empty($validated['galeriaable_type'])) {
                    $galeria->galeriaable_id = $validated['galeriaable_id'];
                    $galeria->galeriaable_type = $validated['galeriaable_type'];
                    $galeria->save();
                }

                return $galeria;
            });

            return response()->json(['data' => $galeria->fresh('galeriaable'), 'message' => 'Galería actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            Log::error("Error al actualizar galería ID: $id");
            return $this->errorResponse('Error al actualizar la galería');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $galeria = Galeria::findOrFail($id);
                $galeria->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar la galería');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $galeria = Galeria::withTrashed()->findOrFail($id);
                $galeria->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente la galería');
        }
    }

    private function validateGaleria(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'disco' => 'required|string|max:20',
            'ruta_archivo' => 'required|string',
            'mime_type' => 'required|string|max:100',
            'tamano_bytes' => 'required|integer',
            'metadatos' => 'nullable|json',
            'galeriaable_id' => 'nullable|integer',
            'galeriaable_type' => 'nullable|string|max:255'
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
