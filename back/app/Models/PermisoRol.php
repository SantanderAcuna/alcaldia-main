<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PermisoRol extends Pivot
{
    protected $table = 'permiso_rol';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['role_id', 'permiso_id'];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }

    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'permiso_id');
    }
}
