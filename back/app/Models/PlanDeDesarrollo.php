<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDeDesarrollo extends Model
{
    /** @use HasFactory<\Database\Factories\PlanDeDesarrolloFactory> */
    use HasFactory;

    protected $table = 'plan_de_desarrollos';

    protected $fillable = [
        'titulo',
        'contenido',
        'galeria_id',
        'alcalde_id',
    ];

    public function alcalde()
    {
        return $this->belongsTo(Alcalde::class);
    }

    // Relación con Galería
    public function galeria()
    {
        return $this->belongsTo(Galeria::class);
    }

    // Relación polimórfica opcional (si se usa morph)
    public function multimedia()
    {
        return $this->morphOne(Galeria::class, 'galeriaable');
    }

    // Scopes
    public function scopeConRelaciones($query)
    {
        return $query->with(['alcalde', 'galeria']);
    }

    public function scopeVigentes($query)
    {
        return $query->whereHas('alcalde', function($q) {
            $q->where('actual', true);
        });
    }

   
}
