<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Publicacion extends Model
{
use HasFactory;

    protected $table = 'publicaciones';


    protected $fillable = [
        'titulo',
        'descripcion',
        'cuerpo'
    ];

    public function Fotos()
    {
        return $this->hasMany(Foto::class);
    }

    public function Documentos()
    {
        return $this->hasMany(Documento::class);
    }
}
