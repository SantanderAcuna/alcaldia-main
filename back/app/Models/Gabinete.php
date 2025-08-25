<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Gabinete extends Model
{
    use HasFactory;

    protected $table = 'gabinetes';

    protected $fillable = [
        'funcionario_id',
        'dependencia_id',
        'perfil_id',
        'fecha_inicio',
        'fecha_fin',
        'cargo',
        'actual',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'actual' => 'boolean',
    ];



    public function funcionario()
    {
        return $this->belongsTo(Funcionarios::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    // Scopes
    public function scopeActuales($query)
    {
        return $query->where('actual', true);
    }

    public function scopeConRelaciones($query)
    {
        return $query->with(['user', 'dependencia', 'perfil']);
    }
}
