<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    // Pertenece a un área
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // Usuarios asignados a este puesto
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
