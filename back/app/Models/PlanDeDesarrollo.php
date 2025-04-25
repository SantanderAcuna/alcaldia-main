<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PlanDeDesarrollo extends Model
{
    /** @use HasFactory<\Database\Factories\PlanDeDesarrolloFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'plan_de_desarrollos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'orden',
        'alcalde_id',
        'galeria_id'
    ];

    public function alcalde()
    {
        return $this->belongsTo(Alcalde::class);
    }



    public function documento()
    {
        return $this->belongsTo(Galeria::class, 'galeria_id');
    }

    public static function crearParaAlcalde($alcaldeId, $archivo, $datos = [])
    {
        return DB::transaction(function () use ($alcaldeId, $archivo, $datos) {
            $documento = Galeria::crearDesdeArchivo($archivo, 'documento');

            return self::create(array_merge($datos, [
                'alcalde_id' => $alcaldeId,
                'galeria_id' => $documento->id
            ]));
        });
    }


}
