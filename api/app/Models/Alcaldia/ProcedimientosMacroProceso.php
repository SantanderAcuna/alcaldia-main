<?php

namespace App\Models\Alcaldia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ProcedimientosMacroProcesoFactory;



class ProcedimientosMacroProceso extends Model
{

    use HasFactory;
    protected $table = 'procedimientos_macro_procesos';

    protected $fillable = [
        'funcion_macro_proceso_id',
        'tipo_procedimiento_id',
        'titulo',
        'descripcion',
        'estado',
    ];

    // ✅ Esta línea obliga a Laravel a usar la factory correcta
    protected static function newFactory()
    {
        return ProcedimientosMacroProcesoFactory::new();
    }

}
