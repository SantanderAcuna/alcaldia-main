<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionMacroProceso extends Model
{
    use HasFactory;

    protected $table = 'funcion_macro_procesos';


    protected $fillable = [
        'macro_proceso_id',
        'tipo_procedimiento_id',
        'descripcion',
        'orden'
    ];


    // Relación con MacroProceso
    public function macroProceso()
    {
        return $this->belongsTo(MacroProceso::class);
    }

    // Relación con TipoProcedimiento (opcional)
    public function tipoProcedimiento()
    {
        return $this->belongsTo(TipoProcedimiento::class);
    }

    // Scopes
    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden');
    }

    public function scopeDelMacroProceso($query, $macroProcesoId)
    {
        return $query->where('macro_proceso_id', $macroProcesoId);
    }
    public function scopeConTipoProcedimiento($query)
    {
        return $query->with('tipoProcedimiento');
    }
}
