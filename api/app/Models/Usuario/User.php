<?php

namespace App\Models\Usuario;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Alcaldia\Gabinete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    /**
// Ejecutar al asignar/revocar permisos
$user->roles()->sync([1, 2]);
Cache::forget("user_{$user->id}_permisos");

// Migración permisos
$table->index('slug'); // Búsqueda ultra rápida

# Redis CLI
redis-cli --scan --pattern "user_*_permisos"
     */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'password',
        'is_active',
        'main_role_id',
    ];



    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    /** Verifica si el usuario tiene un rol activo */
    public function hasRole(string $roleName): bool
    {
        return $this->is_active
            && $this->roles()
            ->where('name', $roleName)
            ->where('is_active', true)
            ->exists();
    }

    /** Obtiene permisos activos a través de sus roles */
    public function permissions()
    {
        return $this->roles()
            ->where('is_active', true)
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->where('is_active', true)
            ->unique('id');
    }

    /** Verifica permiso específico */
    public function hasPermission(string $permissionName): bool
    {
        return $this->is_active
            && $this->permissions()
            ->where('name', $permissionName)
            ->exists();
    }

    public function isAdministrador(): bool
    {
        return $this->role === 'administrador';
    }

    /**
     * Comprueba si este usuario es funcionario.
     *
     * @return bool
     */
    public function isFuncionario(): bool
    {
        return $this->role === 'funcionario';
    }

    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\UserFactory::new();
    }


    /**
     * Perfil único del usuario.
     *
     * @return HasOne
     */
    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }

    /**
     * Gabinetes relacionados con el usuario.
     *
     * @return HasMany
     */
    public function gabinetes()
    {
        return $this->hasMany(Gabinete::class);
    }

    public function tieneRol(array $roles): bool
    {
        // Verificar rol principal
        if ($this->mainRole && in_array($this->mainRole->name, $roles)) {
            return true;
        }

        // Verificar roles adicionales desde la relación muchos a muchos
        return $this->roles()->whereIn('name', $roles)->exists();
    }



    // Relación con rol principal
    public function mainRole()
    {
        return $this->belongsTo(Role::class, 'main_role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }



    // Método para verificar un permiso específico
    public function hasPermiso(string $permisoSlug)
    {
        return $this->roles()->whereHas('permisos', function ($q) use ($permisoSlug) {
            $q->where('slug', $permisoSlug);
        })->exists();
    }

    // Método para obtener todos los permisos del usuario (Optimizado)
    public function getAllPermisos()
    {
        return $this->roles()->with('permisos:slug')
            ->get()
            ->flatMap(fn($role) => $role->permisos->pluck('slug'))
            ->unique();
    }

    // app/Models/User.php

    public function getPermisosAttribute(): array
    {
        return $this->getPermisosCacheados();
    }

    public function getPermisosCacheados(): array
    {
        return Cache::remember(
            "user_{$this->id}_permisos",
            300,
            fn() => $this->roles()
                ->with('permisos:id,slug')
                ->get()
                ->pluck('permisos.*.slug')
                ->flatten()
                ->unique()
                ->toArray()
        );
    }

    public function tienePermiso($permiso): bool
    {
        return in_array($permiso, $this->permisos);
    }
}
