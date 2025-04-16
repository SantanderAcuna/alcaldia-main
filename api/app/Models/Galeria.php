<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    protected $table = 'galeria';

    protected $fillable = [
        'nombre',
        'ruta',
        'tipo',
        'extension',
        'tamano',
        'descripcion',
        'imageable_id',
        'imageable_type',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
    /*
     // Si cada producto tiene una única imagen
     public function imagen()
     {
         return $this->morphOne(Galeria::class, 'imageable');
     }

     // O si un producto puede tener varias imágenes:
     // public function imagenes()
     // {
     //     return $this->morphMany(Galeria::class, 'imageable');
     // }
     */
}
