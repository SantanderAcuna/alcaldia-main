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
        'sexo',
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
        return $this->hasMany(PlanDeDesarrollo::class);
    }



    protected static function booted()
    {
        static::deleting(function (Alcalde $alcalde) {
            if ($alcalde->planDesarrollo) {
                $alcalde->planDesarrollo()->delete();
            }
        });
    }
}
