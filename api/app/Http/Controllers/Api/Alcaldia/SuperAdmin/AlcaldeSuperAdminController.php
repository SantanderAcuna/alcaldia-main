<?php

namespace App\Http\Controllers\Api\Alcaldia\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alcaldia\UpdateAlcaldeRequest;
use App\Models\Alcaldia\Alcalde;
use Illuminate\Http\Request;

class AlcaldeSuperAdminController extends Controller
{
    public function index()
    {
        $alcaldes = Alcalde::withTrashed()
            ->with(['galeria', 'planesDesarrollo'])
            ->advancedFilter()
            ->paginate(request('per_page', 25));

        return response()->json([
            'data' => $alcaldes,
            'meta' => [
                'deleted' => Alcalde::onlyTrashed()->count()
            ]
        ]);
    }

    public function update(UpdateAlcaldeRequest $request, Alcalde $alcalde)
    {
        $alcalde->update($request->validated());

        if($request->has('galeria_id')) {
            $alcalde->galeria()->sync($request->galeria_id);
        }

        return response()->json([
            'data' => $alcalde->load('galeria'),
            'message' => 'Registro de alcalde actualizado'
        ]);
    }

    public function destroy(Alcalde $alcalde)
    {
        $alcalde->delete();

        return response()->noContent();
    }

    // Método adicional para SuperAdmin
    public function forceDelete($id)
    {
        $alcalde = Alcalde::withTrashed()->findOrFail($id);
        $alcalde->forceDelete();

        return response()->noContent();
    }
}
