<?php

namespace App\Models\Alcaldia;

use App\Models\Alcaldia\Dependencia;
use App\Models\Area;
use App\Models\Usuario\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subdireccion extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'estado',
        'dependencia_id'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'deleted_at' => 'datetime'
    ];

    // Relación con Dependencia (N:1)
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    // Relación con Areas (1:N)
    public function areas()
    {
        return $this->hasMany(Area::class);
    }

}
