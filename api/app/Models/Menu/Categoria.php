<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    //
    use HasFactory;


    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion'
    ];

    protected static function newFactory()
    {
        return \Database\Factories\CategoriaFactory::new();
    }


}
