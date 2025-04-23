<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'area_id', // Para la relación jerárquica (área padre)
        'user_id', // Usuario asociado
        'is_lider'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_lider' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Obtiene el usuario asociado al área.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el área padre (relación jerárquica).
     *
     * @return BelongsTo
     */
    public function parentArea(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    /**
     * Obtiene las subáreas (relación jerárquica).
     *
     * @return HasMany
     */
    public function childAreas(): HasMany
    {
        return $this->hasMany(Area::class, 'area_id');
    }

    /**
     * Scope para áreas que son líderes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLideres($query)
    {
        return $query->where('is_lider', true);
    }

    /**
     * Scope para áreas que no son líderes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoLideres($query)
    {
        return $query->where('is_lider', false);
    }

    /**
     * Obtiene el nombre del área con indicación de líder si aplica.
     *
     * @return string
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre . ($this->is_lider ? ' (Líder)' : '');
    }
}
