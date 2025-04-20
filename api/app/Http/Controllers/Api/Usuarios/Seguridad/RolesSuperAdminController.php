<?php

namespace App\Http\Controllers\Api\Usuarios\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuarios\Seguridad\StoreRoleRequest;
use App\Http\Requests\Usuarios\Seguridad\UpdateRoleRequest;
use App\Models\Usuario\Role;
use Illuminate\Http\Request;

class RolesSuperAdminController extends Controller
{
    public function index()
    {
        $roles = Role::with(['permisos', 'users'])
            ->activos()
            ->paginate(20);

        return response()->json([
            'data' => $roles,
            'message' => 'Listado de roles con permisos'
        ], 200);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        return response()->json([
            'data' => $role,
            'message' => 'Rol creado exitosamente'
        ], 201);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return response()->json([
            'data' => $role->fresh(),
            'message' => 'Rol actualizado'
        ], 200);
    }

    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {
            abort(409, 'No se puede eliminar: Tiene usuarios asociados');
        }
        $role->forceDelete();
        return response()->json(null, 204);
    }

    // Método para asignar permisos
    public function asignarPermisos(Role $role, Request $request)
    {
        $permisos = $request->input('permisos');
        $role->permisos()->sync($permisos);
        return response()->json([
            'message' => 'Permisos actualizados'
        ], 200);
    }
}
