<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{


    public function Subdireccion()
    {
        return $this->hasMany(Subdireccion::class);
    }

    // Obtener todos los usuarios del departamento
    public function getAllUsersAttribute()
    {
        return User::whereHas('position.area.subdireccion', function ($query) {
            $query->where('department_id', $this->id);
        })->get();
    }
}
