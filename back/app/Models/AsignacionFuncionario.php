<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;


class AsignacionFuncionario extends Model
{
  use HasFactory;

    protected $table = 'asignaciones_funcionarios';


    protected $fillable = [
        'funcionario_id',
        'secretaria_id',
        'dependencia_id',
        'perfil_id',
        'observacion',
        'fecha_asignacion',
    ];

    public function funcionario()
    {
        return $this->belongsTo(Funcionarios::class);
    }

    public function secretaria()
    {
        return $this->belongsTo(Secretaria::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }
}
