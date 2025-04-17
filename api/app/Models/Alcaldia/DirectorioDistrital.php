<?php

namespace App\Models\Alcaldia;

use Database\Factories\DirectorioDistritalFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectorioDistrital extends Model
{
    /** @use HasFactory<\Database\Factories\DirectorioDistritalFactory> */
    use HasFactory;


    protected $table = 'directorio_distritals';

    protected $fillable = [
        'nombre',
        'funcionario',
        'correo',
        'red_social',
        'tipo_entidad'
    ];


    protected static function newFactory()
    {
        return DirectorioDistritalFactory::new();
    }
}
