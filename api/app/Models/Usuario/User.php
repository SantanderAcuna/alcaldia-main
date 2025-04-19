<?php

namespace App\Models\Usuario;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Alcaldia\Gabinete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
     * Rol principal del usuario.
     *
     * @return BelongsTo
     */
    public function mainRole()
    {
        return $this->belongsTo(Role::class, 'main_role_id');
    }

    /**
     * Roles asignados al usuario (relación muchos a muchos).
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
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

}
