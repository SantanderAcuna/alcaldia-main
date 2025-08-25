<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{

    use HasFactory;

    protected $table = 'cargos';



    protected $fillable = [
        'cargo',
        'descripcion',
        'nivel',

    ];

    // Relación con User
    public function funcionario()
    {
        return $this->belongsTo(Funcionarios::class);
    }
}
