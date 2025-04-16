<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'label', 'is_active',
    ];

    /** Usuarios asignados */
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }

    /** Permisos asociados */
    public function permissions()
    {
        return $this->belongsToMany(Permiso::class)
                    ->withTimestamps();
    }
}
