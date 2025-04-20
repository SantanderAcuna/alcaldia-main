<?php

namespace App\Http\Middleware;

use App\Models\Usuario\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;


class CheckPermiso
{
    public function handle(Request $request, Closure $next, ...$permisosRequeridos)
    {
        $user = $request->user();

        if (!$user || !$this->tienePermisos($user, $permisosRequeridos)) {
            abort(403, 'Acceso no autorizado');
        }

        return $next($request);
    }

    protected function tienePermisos(User $user, array $permisosRequeridos): bool
    {
        // Cargar todos los permisos en memoria con una sola consulta
        $permisosUsuario = $this->getPermisosCacheados($user);

        // Verificación en array en memoria (O(1) por permiso)
        foreach ($permisosRequeridos as $permiso) {
            if (!in_array($permiso, $permisosUsuario)) {
                return false;
            }
        }

        return true;
    }

    protected function getPermisosCacheados(User $user): array
    {
        $cacheKey = "user_{$user->id}_permisos";
        $cacheTime = 300; // 5 minutos

        return Cache::remember($cacheKey, $cacheTime, function() use ($user) {
            return $user->roles()->with('permisos:slug')->get()
                ->pluck('permisos')
                ->flatten()
                ->pluck('slug')
                ->unique()
                ->toArray();
        });
    }
}
