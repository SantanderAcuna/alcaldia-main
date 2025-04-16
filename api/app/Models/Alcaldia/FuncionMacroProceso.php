<?php

namespace App\Models\Alcaldia;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionMacroProceso extends Model
{
    //

    use HasFactory;

    protected $table = 'funcion_macro_procesos';

    protected $fillable = [
        'macro_proceso_id',
        'nombre',
        'descripcion',
        'estado',
    ];


    protected static function newFactory()
    {
        return \Database\Factories\FuncionMacroProcesoFactory::new();
    }
}
