<?php

namespace App\Models\Usuario;

use App\Models\Alcaldia\Area;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    /** Tabla asociada */
    protected $table = 'cargos';

    /** Campos asignables masivamente */
    protected $fillable = [
        'nombre',    // Nombre del cargo
        'area_id',   // ID del área asociada
        'user_id',   // ID del usuario asignado
        'is_lider',  // Indicador si es líder de área
    ];

    /** Casteo de atributos */
    protected $casts = [
        'is_lider' => 'boolean',
    ];

    /**
     * Un cargo pertenece a un área
     *
     * @return BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Un cargo pertenece a un usuario
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
