<?php

namespace App\Models\Usuario;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{

    use HasFactory, SoftDeletes;

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



   

    protected static function newFactory()
    {
        return \Database\Factories\PermisoFactory::new();
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permiso_rols', 'permiso_id', 'role_id');
    }
}
