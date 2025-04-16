<?php

namespace App\Models\Alcaldia;

use Database\Factories\DependenciaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return DependenciaFactory::new();
    }

    // Indica el nombre de la tabla pivot
    protected $table = 'dependencias';

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
