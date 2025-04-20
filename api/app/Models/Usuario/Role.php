<?php

namespace App\Models\Usuario;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Role extends Model
{
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



    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\RoleFactory::new();
    }



}
