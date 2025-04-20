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
        'macro_proceso_id',
        'tipo_procedimiento_id',
        'funcion_macro_proceso_id',
        'titulo',
        'descripcion',
        'orden',
        'estado'
    ];


    protected $casts = [
        'estado' => 'boolean',
        'orden' => 'integer'
    ];

    // Relación 1:1 con MacroProceso (según migración)
    public function macroProceso()
    {
        return $this->belongsTo(MacroProceso::class);
    }

    // Relación opcional con TipoProcedimiento
    public function tipoProcedimiento()
    {
        return $this->belongsTo(TipoProcedimiento::class);
    }

    // Relación opcional con FuncionMacroProceso
    public function funcionMacroProceso()
    {
        return $this->belongsTo(FuncionMacroProceso::class);
    }

    // ✅ Esta línea obliga a Laravel a usar la factory correcta
    protected static function newFactory()
    {
        return ProcedimientosMacroProcesoFactory::new();
    }
}
