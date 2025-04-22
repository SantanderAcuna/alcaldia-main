<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEntidad extends Model
{
    use SoftDeletes;
    use HasFactory;


    protected $table = 'tipo_entidades';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'nivel_jerarquico',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];


    public function directorios()
    {
        return $this->hasMany(DirectorioDistrital::class);
    }


}
