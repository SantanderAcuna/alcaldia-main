<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'label', 'is_active',
    ];

    /** Roles que tienen este permiso */
    public function roles()
    {
        return $this->belongsToMany(Role::class)
                    ->withTimestamps();
    }
}
