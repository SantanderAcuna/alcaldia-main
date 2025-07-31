<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanDocumentos extends Model

{
    use HasFactory, SoftDeletes;

    protected $table = 'plan_documentos';


    protected $fillable = ['plan_desarrollo_id', 'path', 'nombre'];





    public function planDesarrollo()
    {
        return $this->belongsTo(PlanDeDesarrollo::class);
    }
}
