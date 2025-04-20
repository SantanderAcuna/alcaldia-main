<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Galeria extends Model
{

    use HasFactory;


   use SoftDeletes;




   // Nombre explícito de tabla (aunque sigue convención)
   protected $table = 'galerias';

   // Campos asignables masivamente
   protected $fillable = [
       'disco',
       'ruta_archivo',
       'mime_type',
       'tamano_bytes',
       'metadatos',
       'galeriaable_type',
       'galeriaable_id',

   ];

   protected $casts = [
    'metadatos' => 'array',
];



    public function galeriaable()
    {
        return $this->morphTo();
    }

    public function checkRelationships(): self
{
    if ($this->galeriaable()->exists()) {
        abort(409, 'No se puede eliminar: Existen recursos asociados');
    }

    return $this;
}

}
