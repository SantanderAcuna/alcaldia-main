<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pqrsd extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tipo', 'descripcion', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
