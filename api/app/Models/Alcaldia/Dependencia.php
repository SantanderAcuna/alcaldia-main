<?php

namespace App\Models\Alcaldia;

use App\Models\Usuario\Perfil;
use App\Models\Usuario\User;
use Database\Factories\DependenciaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;



use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    use HasFactory;



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

    /**
     * Usuario asignado a la dependencia.
     *
     * @return BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Perfiles asociados a esta dependencia.
     *
     * @return HasMany
     */
    public function perfiles()
    {
        return $this->hasMany(Perfil::class);
    }

    /**
     * Gabinetes relacionados.
     *
     * @return HasMany
     */
    public function gabinetes()
    {
        return $this->hasMany(Gabinete::class);
    }

    /**
     * Macro procesos asociados.
     *
     * @return HasMany
     */
    public function macroProcesos()
    {
        return $this->hasMany(MacroProceso::class);
    }



    protected static function newFactory()
    {
        return \Database\Factories\DependenciaFactory::new();
    }
}
