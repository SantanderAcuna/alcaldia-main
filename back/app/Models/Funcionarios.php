<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Funcionarios extends Model
{
use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [

        'nombres',
        'apellidos',
        'genero',
        'foto',
        'fecha_ingreso',
        'secretaria_id',
        'perfil_id',
        'estado',

    ];



    public function Secretaria()
    {

        return $this->belongsTo(secretaria::class);
    }

    public function Perfil()
    {

        return $this->belongsTo(perfil::class);
    }

    public function organizacion()
    {
        return $this->hasOne(
            AsignacionOrganizacional::class,
            'funcionario_id',
            'id',
            'id',
            'organizacion_id'
        );
    }


    public function asignacion()
    {
        return $this->hasOne(AsignacionOrganizacional::class, 'funcionario_id');
    }



    public function getOrganizacionAttribute()
    {
        return optional($this->asignacion)->organizacion;
    }
}
