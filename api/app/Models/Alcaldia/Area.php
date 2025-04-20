<?php

namespace App\Models\Alcaldia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'subdireccion_id'
    ];

    // Relación con Subdireccion (N:1)
    public function subdireccion()
    {
        return $this->belongsTo(Subdireccion::class);
    }
}
