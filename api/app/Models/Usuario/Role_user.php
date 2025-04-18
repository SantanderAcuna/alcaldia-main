<?php

namespace App\Models\Usuario;


use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{

    protected $table = 'Role_user';

    protected $fillable = ['nombre', 'descripcion'];

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }

    public function permisos()
    {
        return $this->hasMany(Permiso_Rol::class);
    }
}
