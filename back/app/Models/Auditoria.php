<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auditoria extends Model
{
    use HasFactory;

    // 🚫 No usamos created_at ni updated_at automáticos
    public $timestamps = false;

    // ✅ Nombre de la tabla explícito por claridad
   protected $table = 'auditoria';

    // 🛡️ Atributos asignables en masa
    protected $fillable = [
        'tabla',
        'operacion',
        'usuario_bd',
        'datos_anteriores',
        'datos_nuevos',
        'fecha_evento',
    ];

    // 🎯 Casts automáticos para trabajar con arrays/objetos en Laravel
    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'fecha_evento' => 'datetime',
    ];
}
