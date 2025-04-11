<?php

namespace App\Models\Santamarta;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Model;

class ComoLlegar extends Model
{
    //
    protected $table = 'como_llegar';

    protected $casts = [
        'imagenes' => 'array' // Convierte automáticamente el JSON a array
    ];

    protected $fillable = [
        'metodo_transporte',
        'nombre_lugar',
        'direccion',
        'telefono',
        'imagenes',
        'google_maps_iframe',
        'visita_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
