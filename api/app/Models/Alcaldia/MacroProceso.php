<?php

namespace App\Models\Alcaldia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacroProceso extends Model
{
    use HasFactory;

    protected $table = 'macro_procesos';


    protected $fillable = [
        'nombre',
        'mision',
        'vision',
        'dependencia_id',
        'codigo',
        'organigrama_url',
        'estado'
    ];


    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function tipoProcedimientos()
    {
        return $this->hasMany(TipoProcedimiento::class);
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', true);
    }

    public function scopeConDependencia($query)
    {
        return $query->with(['dependencia:id,nombre']);
    }

    public static function newFactory()
    {
        return \Database\Factories\MacroProcesoFactory::new();
    }
}
