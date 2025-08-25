<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dependencia extends Model
{
    use HasFactory;

    protected $table = 'dependencias';


    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'dependencia_padre_id',
        'mision',
        'vision',
        'organigrama'
    ];
    protected $with = ['parent:id,nombre', 'children:id,nombre'];

    // Relación recursiva: Subdependencias
    public function subdependencias(): HasMany
    {
        return $this->hasMany(Dependencia::class, 'dependencia_padre_id');
    }

    // Relación recursiva inversa: Dependencia padre

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_padre_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Dependencia::class, 'dependencia_padre_id');
    }

    // Funciones asociadas a la dependencia
    public function Competencias(): HasMany
    {
        return $this->hasMany(Competencia::class);
    }

    // Funcionarios asignados directamente
    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionarios::class, 'dependencia_id');
    }

    // Trámites asociados
    public function tramites(): HasMany
    {
        return $this->hasMany(Tramite::class);
    }

    // Macroprocesos
    public function macroprocesos(): HasMany
    {
        return $this->hasMany(Macroproceso::class);
    }


    public function organigramaCompleto()
    {
        return Dependencia::with([
            'parent',
            'children' => fn($query) => $query->withCount('funcionarios'),
            'funcionarios.cargo',
            'macroprocesos.procesos'
        ])
            ->whereNull('dependencia_padre_id')
            ->get()
            ->map(function ($secretaria) {
                return [
                    'id' => $secretaria->id,
                    'nombre' => $secretaria->nombre,
                    'subdependencias' => $secretaria->children->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'nombre' => $child->nombre,
                            'funcionarios_count' => $child->funcionarios_count
                        ];
                    })
                ];
            });
    }




    public function procesosPorDependencia($dependenciaId)
    {
        return Dependencia::with([
            'macroprocesos' => fn($query) => $query
                ->with(
                    ['procesos' => fn($q) => $q->select('id', 'nombre', 'macroproceso_id')]
                )->select('id', 'nombre', 'dependencia_id')
        ])
            ->select('id', 'nombre')
            ->find($dependenciaId);
    }



    public function funcionesPorJerarquia($dependenciaId)
    {
        $dependencia = Dependencia::with([
            'parent.funciones',
            'funciones'
        ])->find($dependenciaId);

        return [
            'dependencia' => $dependencia->only('id', 'nombre'),
            'funciones_propias' => $dependencia->funciones,
            'funciones_padre' => $dependencia->parent->funciones ?? []
        ];
    }



    public function tramitesEnJerarquia($dependenciaId)
    {
        $ids = Dependencia::where('id', $dependenciaId)
            ->orWhere('dependencia_padre_id', $dependenciaId)
            ->pluck('id');

        return Tramite::whereIn('dependencia_id', $ids)
            ->with('dependencia:id,nombre')
            ->get();
    }
}
