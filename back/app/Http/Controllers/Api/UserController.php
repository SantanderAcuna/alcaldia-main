<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $users = User::filter($request->only(['name', 'email']))
                ->orderByDesc('created_at')
                ->paginate($request->input('per_page', 15))
                ->withQueryString();

            return response()->json(['data' => $users], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::error('Error al listar usuarios: ' . $e->getMessage());
            return $this->errorResponse('Error al obtener la lista de usuarios');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['data' => $user], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Usuario no encontrado', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al obtener el detalle del usuario');
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $this->validateUser($request);
            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            return response()->json(['data' => $user, 'message' => 'Usuario creado exitosamente'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el usuario');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $this->validateUser($request, true);
            $user = User::findOrFail($id);

            if (!empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            return response()->json(['data' => $user, 'message' => 'Usuario actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Usuario no encontrado', Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el usuario');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el usuario');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->forceDelete();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el usuario');
        }
    }

    private function validateUser(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email' . ($isUpdate ? ',' . $request->route('id') : ''),
            'password' => 'required|string|min:8|confirmed',
        ];

        if ($isUpdate) {
            $rules['password'] = 'sometimes|string|min:8|confirmed';
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
