<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    //
    use HasFactory, SoftDeletes;


    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion'
    ];

    public function directorios(): HasMany
    {
        return $this->hasMany(DirectorioDistrital::class)
            ->with(['tipoEntidad', 'foto'])
            ->orderBy('nombre');
    }

    public function scopeConRelaciones($query)
    {
        return $query->withCount(['directorios as total_activos' => function ($q) {
            $q->whereNull('deleted_at');
        }]);
    }

    public function scopeAdvancedFilter($query)
{
    return $query->when(request('estado'), function($q, $estado) {
            $estado === 'activas' ? $q->whereNull('deleted_at') : $q->onlyTrashed();
        })
        ->when(request('sort'), function($q, $sort) {
            $q->orderBy($sort, request('order', 'asc'));
        });
}

}
