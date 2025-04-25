<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alcalde extends Model
{
    /** @use HasFactory<\Database\Factories\AlcaldeFactory> */
    use HasFactory;


    protected $table = 'alcaldes';


    protected $fillable = [
        'nombre_completo',
        'cargo',
        'fecha_inicio',
        'fecha_fin',
        'objetivo',
        'actual',
        'foto_id',
        'plan_desarrollo_id'
    ];

    protected $casts = [
        'actual' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

   /**
     * Relación con la foto de perfil (imagen)
     */
    public function foto()
    {
        return $this->belongsTo(Galeria::class, 'foto_id');
    }

    /**
     * Relación con el documento del plan de desarrollo
     */
    public function planDesarrollo()
    {
        return $this->belongsTo(Galeria::class, 'plan_desarrollo_id');
    }

    /**
     * Scope para alcaldes actuales
     */
    public function scopeActual($query)
    {
        return $query->where('actual', true);
    }



protected function fechaInicio()
{
    return Attribute::make(
        get: fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d')
    );
}

protected function fechaFin()
{
    return Attribute::make(
        get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : null
    );
}

}
