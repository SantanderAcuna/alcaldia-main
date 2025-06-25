<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermisoRol extends Pivot
{
    use HasFactory;

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
