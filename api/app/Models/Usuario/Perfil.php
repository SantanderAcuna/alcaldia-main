<?php

namespace App\Models\Usuario;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';


    use HasFactory;


    protected static function newFactory()
    {
        return \Database\Factories\PerfilFactory::new();
    }


}
