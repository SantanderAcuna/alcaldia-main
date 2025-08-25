<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Competencia extends Model
{
    /** @use HasFactory<\Database\Factories\CompetenciaFactory> */
    use HasFactory;


    protected $fillable = ['competencia', 'orden', 'dependencia_id'];

    public function dependencia(): BelongsTo
    {
        return $this->belongsTo(Dependencia::class);
    }
}
