<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'fecha_nacimiento',
        'lugar_nacimiento',
        'direccion',
        'ciudad',
        'direccion',
        'estado_civil',
        'sexo',
        'nacionalidad',
        'tipo_sangre',
        'foto',
        'cargo',
        'tipo_usuario',
        'tipo_documento',
        'numero_documento',
        'email',
        'password',
        'phone',
        'position_id',
       

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    // Puesto asignado al usuario
    public function position()
    {
        return $this->belongsTo(Cargo::class);
    }

    // Si el usuario es director de una división
    public function directedDivision()
    {
        return $this->hasOne(Subdireccion::class, 'director_id');
    }

    // Si el usuario es manager de un área
    public function managedArea()
    {
        return $this->hasOne(Area::class, 'manager_id');
    }

    // Verifica si el usuario tiene un rol específico
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
