<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subdireccion extends Model
{
    use SoftDeletes;

    protected $table = 'subdirecciones';
    protected $fillable = [
        'nombre',
        'descripcion',
        'dependencia_id',
        'estado'
    ];
    protected $casts = [
        'estado' => 'boolean'
    ];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
