<?php

namespace App\Http\Controllers\Api;

use App\Models\Categoria;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CategoriaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $categorias = Categoria::query()
                ->filter($request->only(['nombre']))
                ->orderBy('nombre')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $categorias], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar categorias: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener las categorías');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $categoria = Categoria::findOrFail($id);
            return response()->json(['data' => $categoria], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Categoría no encontrada', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Error al mostrar categoría ID: $id");
            return $this->errorResponse('Error al obtener el detalle de la categoría');
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $categoria = DB::transaction(function () use ($request) {
                $validated = $this->validateCategoria($request);
                return Categoria::create($validated);
            });

            return response()->json(['data' => $categoria, 'message' => 'Categoría creada exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            Log::error('Error al crear categoría: ' . $e->getMessage());
            return $this->errorResponse('Error al crear la categoría');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $categoria = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateCategoria($request, true);
                $categoria = Categoria::findOrFail($id);
                $categoria->update($validated);
                return $categoria;
            });

            return response()->json(['data' => $categoria, 'message' => 'Categoría actualizada'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Categoría no encontrada', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Error al actualizar categoría ID: $id");
            return $this->errorResponse('Error al actualizar la categoría');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $categoria = Categoria::findOrFail($id);
                $categoria->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Categoría no encontrada', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Error al eliminar categoría ID: $id");
            return $this->errorResponse('Error al eliminar la categoría');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $categoria = Categoria::withTrashed()->findOrFail($id);
                $categoria->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente la categoría');
        }
    }

    private function validateCategoria(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'nombre' => 'required|string|max:255|unique:categorias,nombre' . ($isUpdate ? "," . $request->route('id') : ''),
            'slug' => 'required|string|max:255|unique:categorias,slug' . ($isUpdate ? "," . $request->route('id') : ''),
            'descripcion' => 'nullable|string'
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
