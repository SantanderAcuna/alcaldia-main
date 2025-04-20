<?php

namespace App\Models\Alcaldia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProcedimiento extends Model
{
    /** @use HasFactory<\Database\Factories\Models\Alcaldia\TipoProcedimientoFactory> */
    use HasFactory;

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

    public static function newFactory()
    {
        return \Database\Factories\TipoProcedimientoFactory::new();
    }
}
