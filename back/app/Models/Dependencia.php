<?php

namespace App\Models;

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
     * Macro procesos asociados.
     *
     * @return HasMany
     */


    public function responsable()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->withDefault([
                'nombres' => 'Responsable no asignado',
                'email' => 'sin-asignar@dominio.com'
            ]);
    }

    // 2. Macroprocesos asociados
    public function macroProcesos()
    {
        return $this->hasMany(MacroProceso::class);
    }

    // 3. Gabinetes de trabajo
    public function gabinetes()
    {
        return $this->hasMany(Gabinete::class);
    }

    // 4. Perfiles profesionales
    public function perfiles()
    {
        return $this->hasMany(Perfil::class);
    }

    // 5. Directorio distrital a través de TipoEntidad
    public function directoriosDistritales()
    {
        return $this->hasManyThrough(
            DirectorioDistrital::class,
            TipoEntidad::class,
            'dependencia_id', // FK en tipo_entidades
            'tipo_entidad_id', // FK en directorio_distritals
            'id', // PK en dependencias
            'id' // PK en tipo_entidades
        );
    }

    // Scope para carga eficiente de relaciones
    public function scopeWithAllRelations($query)
    {
        return $query->with([
            'responsable',
            'macroProcesos',
            'gabinetes.user',
            'perfiles',
            'directoriosDistritales.categoria'
        ]);
    }

    public function checkForRelationships(array $relations): void
    {
        foreach ($relations as $relation) {
            if ($this->$relation()->exists()) {
                abort(409, "No se puede eliminar: Existen {$relation} relacionados");
            }
        }
    }

}
