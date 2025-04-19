<?php

namespace App\Models\Menu;

use App\Models\Alcaldia\DirectorioDistrital;
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

    public function directorios(): HasMany
    {
        return $this->hasMany(DirectorioDistrital::class);
    }

    protected static function newFactory()
    {
        return \Database\Factories\CategoriaFactory::new();
    }


}
