<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
use HasFactory;

    protected $table = 'publicacion_documentos';

    protected $fillable = ['publicacion_id', 'ruta', 'titulo', 'descripcion'];

    public function Publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
}
