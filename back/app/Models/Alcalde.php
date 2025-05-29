<?php

namespace App\Models;

use App\Models\PlanDeDesarrollo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alcalde extends Model
{

    use HasFactory, SoftDeletes;


    protected $table = 'alcaldes';

 protected $fillable = [
        'nombre_completo',
        'fecha_inicio',
        'fecha_fin',
        'presentacion',
        'foto_path',
        'actual'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'actual' => 'boolean'
    ];

    public function planDesarrollo()
    {
        return $this->hasOne(PlanDeDesarrollo::class);
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
            get: fn($value) => \Carbon\Carbon::parse($value)->format('Y-m-d')
        );
    }

    protected function fechaFin()
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : null
        );
    }
}
