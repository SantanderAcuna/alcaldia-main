<?php

namespace App\Models\Usuario;

use App\Models\Alcaldia\Dependencia;
use App\Models\Alcaldia\Gabinete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    /** @use HasFactory<\Database\Factories\Usuario\PerfilFactory> */
    use HasFactory;
    protected $table = 'perfiles';

use HasFactory;

protected $fillable = [
'user_id',
'dependencia_id',
'titulo_profesional',
'especializacion',
'doctorado',
'foto_url',
'resumen_biografico',
'experiencia_publica',
];

protected $casts = [
'experiencia_publica' => 'array',
];

   // Relación con User
   public function user()
   {
       return $this->belongsTo(User::class);
   }

   // Relación con Dependencia (opcional)
   public function dependencia()
   {
       return $this->belongsTo(Dependencia::class);
   }

   // Scopes
   public function scopeConRelaciones($query)
   {
       return $query->with(['user', 'dependencia']);
   }

/**
* Gabinete vinculado a este perfil.
*
* @return HasOne
*/
public function gabinete()
{
return $this->hasOne(Gabinete::class);
}



protected static function newFactory()
{
return \Database\Factories\Usuario\PerfilFactory::new();
}

}
