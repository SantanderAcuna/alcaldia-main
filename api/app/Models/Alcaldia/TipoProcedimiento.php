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



    public static function newFactory()
 {
     return \Database\Factories\TipoProcedimientoFactory::new();
 }
}
