<?php

namespace App\Models\Alcaldia;

use Database\Factories\DirectorioDistritalFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirectorioDistrital extends Model
{
    /** @use HasFactory<\Database\Factories\DirectorioDistritalFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'directorio_distritals';

    protected $fillable = [
        'nombre',
        'funcionario',
        'correo',
        'red_social',
        'tipo_entidad'
    ];

    protected $casts = [
        'contactos' => 'array',
    ];



    protected static function newFactory()
    {
        return DirectorioDistritalFactory::new();
    }
}
