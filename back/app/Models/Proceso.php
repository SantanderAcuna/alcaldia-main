<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proceso extends Model
{

    use HasFactory;

    protected $table = 'procesos';

    protected $fillable = ['proceso', 'codigo', 'descripcion', 'macroproceso_id'];



    public function dependencia()
    {
        return $this->macroproceso->dependencia;
    }


    public function macroproceso(): BelongsTo
    {
        return $this->belongsTo(Macroproceso::class, 'macroproceso_id');
    }
}
