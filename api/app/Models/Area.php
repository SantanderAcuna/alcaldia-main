<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    // Pertenece a una división
    public function subdireccion()
    {
        return $this->belongsTo(Subdireccion::class);
    }

    // Manager asignado (puede ser null)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Puestos en esta área
    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}
