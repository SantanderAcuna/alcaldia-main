<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tipo extends Model
{
use HasFactory;
     protected $table = 'tipos';

    protected $fillable = [
        'nombre'
    ];

    public function Publicaciones()
    {

        return $this->belongsTo(Publicacion::class);
    }
}
