<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos';
    protected $fillable = [
        'nombre',
        'grupo',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'permiso_rols', 'permiso_id', 'role_id');
    }
}
