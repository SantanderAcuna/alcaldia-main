<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galeria extends Model
{

    use HasFactory, SoftDeletes;

    

    protected $fillable = [
        'disco',
        'ruta_archivo',
        'nombre_original',
        'mime_type',
        'tamano_bytes',
        'tipo_archivo',
        'metadatos',
        'galeriaable_id',
        'galeriaable_type'
    ];

    protected $casts = [
        'metadatos' => 'array',
    ];

    // Relación polimórfica
    public function galeriaable()
    {
        return $this->morphTo();
    }

    // Helpers
    public function esImagen()
    {
        return $this->tipo_archivo === 'imagen';
    }

    public function esDocumento()
    {
        return $this->tipo_archivo === 'documento';
    }

    // Factory method
    public static function crearDesdeArchivo($archivo, $tipo)
    {
        return self::create([
            'disco' => 'public',
            'ruta_archivo' => $archivo->store('public'),
            'nombre_original' => $archivo->getClientOriginalName(),
            'mime_type' => $archivo->getMimeType(),
            'tamano_bytes' => $archivo->getSize(),
            'tipo_archivo' => $tipo,
            'metadatos' => [
                'extension' => $archivo->extension(),
                'subido_por' => auth()->id() ?? null
            ]
        ]);
    }


}
