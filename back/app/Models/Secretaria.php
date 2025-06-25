<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretaria extends Model
{
    use HasFactory;

    protected  $table = 'secretarias';

    protected $fillable =
    [
        'mision',
        'vision',
        'organigrama'
    ];

    public function Funciones()
    {
        return $this->hasMany(Funcion::class);
    }


    public function Funcionarios()
    {
        return $this->hasMany(funcionarios::class);
    }


    public function Dependencias()
    {

        return $this->hasMany(Dependencia::class);
    }

    public function Tramites()
    {

        return $this->hasMany(Tramite::class);
    }

    public function asignaciones()
{
    return $this->morphMany(AsignacionOrganizacional::class, 'organizacion');
}
}
