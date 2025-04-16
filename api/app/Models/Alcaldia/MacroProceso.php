<?php

namespace App\Models\Alcaldia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MacroProceso extends Model
{
    use HasFactory;

   protected $table = 'macro_procesos';

   
   public static function newFactory()
{
    return \Database\Factories\MacroProcesoFactory::new();
}
}
