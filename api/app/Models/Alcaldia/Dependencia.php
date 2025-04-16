<?php

namespace App\Models\Alcaldia;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    // Indica el nombre de la tabla pivot
    protected $table = 'dependencia_perfil_user';

    // Deshabilitamos el autoincremento ya que la clave primaria es compuesta
    public $incrementing = false;

    // Laravel no soporta claves compuestas en modelos de forma nativa, por lo que dejamos primaryKey en null
    protected $primaryKey = null;

    // Definimos los campos asignables
    protected $fillable = [
        'user_id',
        'dependencia_id',
        'perfil_id',
    ];
}
