<?php



namespace App\Http\Controllers\api\publico;

use App\Http\Controllers\Controller;
use App\Models\PlanDeDesarrollo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as RoutingController;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;



class PlanDeDesarrolloController extends RoutingController
{
    public function index(Request $request): JsonResponse
    {
        try {
            $data = PlanDeDesarrollo::with(['alcalde'])
                ->orderByDesc('id')
                ->get();

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
            $item = PlanDeDesarrollo::with(['galeria', 'alcalde'])->findOrFail($id);
            return response()->json(['data' => $item], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse('Plan de desarrollo no encontrado', Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $plan = DB::transaction(function () use ($request) {
                $validated = $this->validatePlan($request);
                return PlanDeDesarrollo::create($validated);
            });

            return response()->json(['data' => $plan, 'message' => 'Plan de desarrollo creado'], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al crear el plan de desarrollo');
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $plan = DB::transaction(function () use ($request, $id) {
                $validated = $this->validatePlan($request, true);
                $plan = PlanDeDesarrollo::findOrFail($id);
                $plan->update($validated);
                return $plan;
            });

            return response()->json(['data' => $plan, 'message' => 'Plan de desarrollo actualizado'], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al actualizar el plan de desarrollo');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $plan = PlanDeDesarrollo::findOrFail($id);
                $plan->delete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar el plan de desarrollo');
        }
    }

    public function forceDestroy(int $id): JsonResponse
    {
        try {
            DB::transaction(function () use ($id) {
                $plan = PlanDeDesarrollo::withTrashed()->findOrFail($id);
                $plan->forceDelete();
            });

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Error al eliminar permanentemente el plan de desarrollo');
        }
    }

    private function validatePlan(Request $request, bool $isUpdate = false): array
    {
        $rules = [
            'titulo' => 'required|string',
            'contenido' => 'nullable|string',
            'galeria_id' => 'required|exists:galerias,id',
            'alcalde_id' => 'required|exists:alcaldes,id'
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
