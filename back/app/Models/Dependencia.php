<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
      use HasFactory;

    protected $table = 'dependencias';


    protected $fillable = [
        'nombre',
        'descripcion',
        'secretaria_id',
    ];


    protected $casts = [
        'estado' => 'boolean'
    ];




    public function Secretaria()
    {
        return $this->belongsTo(Secretaria::class);
    }

    public function Tramites()
    {

        return $this->hasMany(Tramite::class);
    }

    public function asignaciones()
    {
        return $this->morphMany(AsignacionOrganizacional::class, 'organizacion');
    }
}
