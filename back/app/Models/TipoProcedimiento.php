<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProcedimiento extends Model
{
    /** @use HasFactory<\Database\Factories\TipoProcedimientoFactory> */
    use HasFactory;

    protected $table = 'tipo_procedimientos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
        'macro_proceso_id',
    ];

    // Relación con FuncionMacroProceso
    public function funcionesMacro()
    {
        return $this->hasMany(FuncionMacroProceso::class);
    }

    // Relación con ProcedimientoMacroProceso
    public function procedimientosMacro()
    {
        return $this->hasMany(ProcedimientoMacroProceso::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeConRelaciones($query)
    {
        return $query->with(['funcionesMacro', 'procedimientosMacro']);
    }
    public function scopeConMacroProceso($query)
    {
        return $query->with('macroProceso');
    }
    public function scopeConMacroProcesoYFunciones($query)
    {
        return $query->with(['macroProceso', 'funcionesMacro']);
    }
}
