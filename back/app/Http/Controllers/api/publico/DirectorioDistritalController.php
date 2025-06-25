<?php

namespace App\Http\Controllers\api\publico;

use App\Models\DirectorioDistrital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DirectorioDistritalController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = DirectorioDistrital::with(['categoria', 'tipoEntidad', 'foto'])
                ->filter($request->only(['nombre', 'email']))
                ->orderBy('nombre')
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
            $entry = DirectorioDistrital::with(['categoria', 'tipoEntidad', 'foto'])->findOrFail($id);
            return response()->json(['data' => $entry], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Registro no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $entry = DB::transaction(function () use ($request) {
                $validated = $this->validateDirectorio($request);
                return DirectorioDistrital::create($validated);
            });

            return response()->json(['data' => $entry, 'message' => 'Registro creado exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el registro');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $entry = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateDirectorio($request, true);
                $entry = DirectorioDistrital::findOrFail($id);
                $entry->update($validated);
                return $entry;
            });

            return response()->json(['data' => $entry, 'message' => 'Registro actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el registro');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $entry = DirectorioDistrital::findOrFail($id);
                $entry->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el registro');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $entry = DirectorioDistrital::withTrashed()->findOrFail($id);
                $entry->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el registro');
        }
    }

    private function validateDirectorio(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_entidad_id' => 'required|exists:tipo_entidads,id',
            'foto_id' => 'nullable|exists:galerias,id',
            'nombre' => 'required|string|max:150',
            'cargo' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:directorio_distritals,email' . ($isUpdate ? ',' . $request->route('id') : ''),
            'contactos' => 'required|json',
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
