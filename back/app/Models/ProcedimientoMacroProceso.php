<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedimientoMacroProceso extends Model
{
    /** @use HasFactory<\Database\Factories\ProcedimientoMacroProcesoFactory> */
    use HasFactory;

    protected $table = 'procedimiento_macro_procesos';


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

    // Scopes
}
