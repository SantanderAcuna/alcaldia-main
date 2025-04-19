<?php

namespace App\Models;

use App\Models\Alcaldia\DirectorioDistrital;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEntidad extends Model
{
    /** @use HasFactory<\Database\Factories\TipoEntidadFactory> */
    use SoftDeletes;
    use HasFactory;

    protected $table = 'tipo_entidades';

    protected $fillable = ['nombre', 'slug', 'descripcion', 'nivel_jerarquico', 'activo'];


    protected $casts = [
        'activo' => 'boolean',
        'nivel_jerarquico' => 'integer',
    ];
    public function directorios()
    {
        return $this->hasMany(DirectorioDistrital::class);
    }


    protected static function newFactory()
    {
        return \Database\Factories\TipoEntidadFactory::new();
    }
}
