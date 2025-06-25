<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Perfiles extends Model
{
use HasFactory;

    protected $table = 'perfiles';

   protected $fillable = [

        'titulo_profesional',
        'especializacion',
        'resumen_biografico',
        'experiencia_publica'
    ];



    public function funcionarios(){

    return $this->hasOne(Funcionarios::class);

    }
}
