<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Funcion extends Model
{
use HasFactory;
    use HasFactory;

    protected  $table = 'funciones_sec';

    protected $fillable = [

        'descripcion',
        'orden',
        'secretaria_id'
    ];

    public function secretaria()
    {
        return $this->belongsTo(Secretaria::class);
    }
}
