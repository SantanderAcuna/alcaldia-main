<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MacroProceso extends Model
{

    use HasFactory;

    protected $table = 'macroprocesos';

    protected $fillable = [
        'macrop',
        'codigo',
        'descripcion',
        'dependencia_id'
    ];

    public function dependencia(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class);
    }



    public function procesos(): HasMany
    {
        return $this->hasMany(Proceso::class, 'macroproceso_id');
    }
}
