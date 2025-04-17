<?php

namespace App\Models\Alcaldia;
use App\Models\Galeria;
use Database\Factories\PlanDeDesarrolloFactory;
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

    // Relación con Galería
    public function galeria()
    {
        return $this->belongsTo(Galeria::class);
    }

    // Relación con Alcalde
    public function alcalde()
    {
        return $this->belongsTo(Alcalde::class);
    }

    protected static function newFactory()
    {
        return PlanDeDesarrolloFactory::new();
    }
}
