<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tramite extends Model
{
    use HasFactory;
    protected $table = 'tramites';

    protected $fillable = [
        'tramite',
        'codigo',
        'descripcion',
        'dependencia_id',
    ];



    public function Dependencia()
    {

        return $this->belongsTo(Dependencia::class);
    }
}
