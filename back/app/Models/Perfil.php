<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;
    protected $table = 'perfiles';



    protected $fillable = [
        'alcalde_id',
        'titulo_profesional',
        'especializacion',
        'doctorado',
        'foto_path',
        'documento_path',
        'resumen_biografico',
        'experiencia_publica',
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
}
