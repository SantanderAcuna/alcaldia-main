<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tramite extends Model
{
use HasFactory;
    protected $table = 'tramites';

    protected $fillable = [
        'nombre',
        'descripcion',
        'subdirecion_id',
        'secretaria_id'
    ];

    public function Secretaria()
    {

        return $this->belongsTo(Secretaria::class);
    }

      public function Dependencia()
    {

        return $this->belongsTo(Dependencia::class);
    }



}
