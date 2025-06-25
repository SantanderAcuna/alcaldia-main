<?php

namespace App\Models;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionOrganizacional extends Model
{
    use HasFactory;
    protected $table = 'asignaciones_organizacionales';

    protected $fillable = [
        'funcionario_id',
        'organizacion_id',
        'organizacion_type'
    ];


//

    public function funcionario()
    {
        return $this->belongsTo(Funcionarios::class, 'funcionario_id');
    }

    public function organizacion()
{
    return $this->morphTo();
}
}
