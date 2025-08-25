<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionFuncionario extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_funcionarios';


    protected $fillable = [
        'funcionario_id',
        'dependencia_id',
        'cargo_id',
        'observacion',
        'fecha_inicio',
        'fecha_fin'
    ];


    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionarios::class);
    }

    public function dependencia(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(cargo::class);
    }
}
