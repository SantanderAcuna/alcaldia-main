<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionarios extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'nombres',
        'apellidos',
        'genero',
        'foto',
        'correo',
        'linkedin',
        'departamento',
        'municipio',
        'cargo_id',
        'perfil_id',

    ];

    protected $casts = ['estado' => 'boolean',  'fecha_nacimiento' => 'date'];


    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class);
    }

    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class);
    }

    public function dependencia(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionFuncionario::class);
    }



    public function responsableConHistorial($dependenciaId)
    {
        return Dependencia::with([
            'funcionarios' => fn($query) => $query->active(),
            'asignaciones' => fn($query) => $query
                ->with('funcionario', 'cargo')
                ->latest('fecha_inicio')
                ->take(5)
        ])
            ->findOrFail($dependenciaId);
    }
}
