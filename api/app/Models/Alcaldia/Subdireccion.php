<?php

namespace App\Models\Alcaldia;

use App\Models\Alcaldia\Dependencia;
use App\Models\Area;
use App\Models\Usuario\User;
use Illuminate\Database\Eloquent\Model;

class Subdireccion extends Model
{


     // Pertenece a un departamento
     public function dependencia()
     {
         return $this->belongsTo(Dependencia::class);
     }

     // Director asignado (puede ser null)
     public function director()
     {
         return $this->belongsTo(User::class, 'director_id');
     }

     // Áreas bajo esta división
     public function areas()
     {
         return $this->hasMany(Area::class);
     }

}
