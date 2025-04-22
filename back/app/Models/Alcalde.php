<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alcalde extends Model
{
    /** @use HasFactory<\Database\Factories\AlcaldeFactory> */
    use HasFactory;


    protected $table = 'alcaldes';


    protected $fillable = [
        'galeria_id',
        'nombre_completo',
        'cargo',
        'fecha_inicio',
        'fecha_fin',
        'objetivo',
        'actual',
    ];

    /**
     * Al crear un Funcionario, fija automáticamente el campo `role`.
     */



    public function galeria()
    {
        return $this->belongsTo(Galeria::class);
    }
    public function planesDesarrollo()
    {
        return $this->hasMany(PlanDeDesarrollo::class);
    }

    // Scopes para consultas comunes
    public function scopeActual($query)
    {
        return $query->where('actual', true);
    }

    public function scopeConGaleria($query)
    {
        return $query->with(['galeria' => function($q) {
            $q->select('id', 'ruta_archivo', 'disco');
        }]);
    }

}
