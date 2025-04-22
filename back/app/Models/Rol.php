<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory, SoftDeletes;

    use HasFactory, SoftDeletes;


    protected $table = 'roles';


    protected $fillable = [
        'name', 'slug', 'label', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];



    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'permiso_rols', 'role_id', 'permiso_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function scopeActivos($query)
    {
        return $query->where('is_active', true);
    }




}
