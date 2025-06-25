<?php

namespace App\Models;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $table = 'publicacion_fotos';

    protected $fillable = ['publicacion_id', 'ruta', 'alt', 'orden'];

    public function Publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
}
