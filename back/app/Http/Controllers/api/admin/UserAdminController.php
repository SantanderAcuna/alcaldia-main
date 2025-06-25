<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Perfil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserAdminController
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validación específica para creación
            $validated = $request->validate([
                'name' => 'required|string|max:255',

                'email' => ['required', 'email', 'max:255', Rule::unique('users')],


                'password' => 'required|string|min:8|confirmed',
                'titulo_profesional' => 'nullable|string|max:255',
                'especializacion' => 'nullable|string|max:255',
                'doctorado' => 'nullable|string|max:255',
                'resumen_biografico' => 'nullable|string',

                'experiencia_publica' => 'required|array|min:1',
                'experiencia_publica.*' => 'string|max:255|distinct',


                'dependencia_id' => 'nullable|integer|exists:dependencias,id',
                'foto' => 'nullable|image|mimes:jpeg,png|max:2048',
                'documento' => 'nullable|file|mimes:pdf|max:5120'
            ]);

            // Lógica de creación
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),

            ]);

            // Procesamiento de archivos
            $filePaths = [];
            if ($request->hasFile('foto')) {
                $filePaths['foto_url'] = $request->file('foto')->store('perfiles', 'public');
            }
            if ($request->hasFile('documento')) {
                $filePaths['documento_url'] = $request->file('documento')->store('documentos', 'public');
            }

            // Creación de perfil
            Perfil::create([
                'user_id' => $user->id,
                'dependencia_id' => $validated['dependencia_id'] ?? null,
                'titulo_profesional' => $validated['titulo_profesional'] ?? null,
                'especializacion' => $validated['especializacion'] ?? null,
                'doctorado' => $validated['doctorado'] ?? null,
                'foto_url' => $filePaths['foto_url'] ?? null,
                'documento_url' => $filePaths['documento_url'] ?? null,
                'resumen_biografico' => $validated['resumen_biografico'] ?? null,
                'experiencia_publica' => $validated['experiencia_publica']
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $user->load('perfil'),
                'message' => 'Alcalde creado exitosamente'
            ], Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear alcalde: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Excepción capturada',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    // ▶ 2. UPDATE (ACTUALIZACIÓN CON VALIDACIÓN PROPIA)
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // Validación específica para actualización
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => ['sometimes' | 'required' | 'email' | 'max:255' | Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')],
                'password' => 'sometimes|nullable|string|min:8|confirmed',
                'titulo_profesional' => 'nullable|string|max:255',
                'especializacion' => 'nullable|string|max:255',
                'doctorado' => 'nullable|string|max:255',
                'resumen_biografico' => 'nullable|string',
                'experiencia_publica' => 'required|array|min:1',
                'experiencia_publica.*' => 'string|max:255|distinct',

                'dependencia_id' => 'nullable|integer|exists:dependencias,id',
                'foto' => 'nullable|image|mimes:jpeg,png|max:2048',
                'documento' => 'nullable|file|mimes:pdf|max:5120'
            ]);

            // Actualización de usuario
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }
            $user->update(array_filter($validated));

            // Manejo de archivos
            $filePaths = [];
            if ($request->hasFile('foto')) {
                if ($user->perfil->foto_url) {
                    Storage::disk('public')->delete($user->perfil->foto_url);
                }
                $filePaths['foto_url'] = $request->file('foto')->store('perfiles', 'public');
            }
            if ($request->hasFile('documento')) {
                if ($user->perfil->documento_url) {
                    Storage::disk('public')->delete($user->perfil->documento_url);
                }
                $filePaths['documento_url'] = $request->file('documento')->store('documentos', 'public');
            }

            // Actualización de perfil
            $user->perfil()->updateOrCreate(
                ['user_id' => $user->id],
                array_merge(
                    $request->only([
                        'titulo_profesional',
                        'especializacion',
                        'doctorado',
                        'resumen_biografico',
                        'dependencia_id'
                    ]),
                    ['experiencia_publica' => $validated['experiencia_publica']],
                    $filePaths
                )
            );

            DB::commit();
            return response()->json([
                'success' => true,
                'data' => $user->fresh()->load('perfil'),
                'message' => 'Alcalde actualizado exitosamente'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar alcalde ID {$id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ▶ 3. SHOW (CONSULTA INDIVIDUAL)
    public function show($id)
    {
        try {
            $user = User::with('perfil')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            Log::error("Error al consultar alcalde ID {$id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener información'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // ▶ 4. INDEX (LISTADO PAGINADO)
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $query = User::with('perfil')->where('alcalde');

            // Filtros
            if ($request->has('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if ($request->has('email')) {
                $query->where('email', $request->email);
            }

            $data = $query->paginate($perPage);

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

    // ▶ 5. DESTROY (ELIMINACIÓN SEGURA)
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);

            // Eliminar archivos primero
            if ($user->perfil) {
                if ($user->perfil->foto_url) {
                    Storage::disk('public')->delete($user->perfil->foto_url);
                }
                if ($user->perfil->documento_url) {
                    Storage::disk('public')->delete($user->perfil->documento_url);
                }
                $user->perfil()->delete();
            }

            $user->delete();
            DB::commit();

            return response()->noContent();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al eliminar alcalde ID {$id}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar registro'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }}
