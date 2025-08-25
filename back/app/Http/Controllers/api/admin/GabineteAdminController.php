<?php

namespace App\Http\Controllers\api\admin;

use App\Models\Gabinete;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GabineteAdminController
{
    public function index(Request $request)
    {
        try {
            $data = Gabinete::with(['funcionario', 'dependencia', 'perfil'])
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

    public function show(int $id)
    {
        try {
            $data = Gabinete::with(['user', 'dependencia', 'perfil'])->findOrFail($id);
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

    public function store(Request $request)
    {
        try {
            $data = DB::transaction(function () use ($request) {
                $validated = $this->validateGabinete($request);
                return Gabinete::create($validated);
            });

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

    public function update(Request $request, int $id)
    {
        try {
            $data = DB::transaction(function () use ($request, $id) {
                $validated = $this->validateGabinete($request, true);
                $item = Gabinete::findOrFail($id);
                $item->update($validated);
                return $item;
            });

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

    public function destroy(int $id): JsonResponse
    {
        try {
            $data =  DB::transaction(function () use ($id) {
                $item = Gabinete::findOrFail($id);
                $item->delete();
            });

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

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            $data =   DB::transaction(function () use ($id) {
                $item = Gabinete::withTrashed()->findOrFail($id);
                $item->forceDelete();
            });

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
}
