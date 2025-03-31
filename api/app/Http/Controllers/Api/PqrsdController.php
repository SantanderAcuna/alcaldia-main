<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pqrsd;
use Illuminate\Support\Facades\Validator;

class PqrsdController extends Controller
{
    // Obtener todas las PQRSD
    public function index()
    {
        return response()->json(Pqrsd::with('user')->get(), 200);
    }

    // Crear una nueva PQRSD
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'tipo' => 'required|in:Petición,Queja,Reclamo,Sugerencia,Denuncia',
            'descripcion' => 'required|string|min:10',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $pqrsd = Pqrsd::create($request->all());
    
        return response()->json([
            'message' => 'PQRSD creada exitosamente',
            'data' => $pqrsd
        ], 201);
    }

    // Obtener una PQRSD específica
    public function show($id)
    {
        $pqrsd = Pqrsd::find($id);

        if (!$pqrsd) {
            return response()->json(['message' => 'PQRSD no encontrada'], 404);
        }

        return response()->json($pqrsd, 200);
    }

    // Actualizar una PQRSD
    public function update(Request $request, $id)
    {
        $pqrsd = Pqrsd::find($id);

        if (!$pqrsd) {
            return response()->json(['message' => 'PQRSD no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'tipo' => 'in:Petición,Queja,Reclamo,Sugerencia,Denuncia',
            'descripcion' => 'string',
            'estado' => 'in:Pendiente,En Proceso,Resuelto',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $pqrsd->update($request->all());

        return response()->json([
            'message' => 'PQRSD actualizada exitosamente',
            'data' => $pqrsd
        ], 200);
    }

    // Eliminar una PQRSD
    public function destroy($id)
    {
        $pqrsd = Pqrsd::find($id);

        if (!$pqrsd) {
            return response()->json(['message' => 'PQRSD no encontrada'], 404);
        }

        $pqrsd->delete();

        return response()->json(['message' => 'PQRSD eliminada exitosamente'], 200);
    }
}
