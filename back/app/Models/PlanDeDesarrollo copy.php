<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Traits\Auditable;

class PlanDeDesarrollo extends Model
{
    use SoftDeletes;

    /** Nombre explícito de la tabla */
    protected $table = 'plan_de_desarrollos';

    /** Asignación masiva */
    protected $fillable = [
        'titulo',
        'descripcion',
        'document_path',
        'alcalde_id',
    ];

    /** Cast JSON ⇄ array para múltiples archivos */
    protected $casts = [
        'document_path' => 'array',
    ];

    /** Atributos calculados a serializar */
    protected $appends = ['document_url'];

    /* ───────────────────── Relaciones ───────────────────── */

    public function alcalde()
    {
        return $this->belongsTo(Alcalde::class);
    }

    /* ───────────────────── Accessors ───────────────────── */

    /**
     * Devuelve un array con la URL pública de cada archivo.
     * Estructura esperada en document_path:
     * [
     *   { "nombre": "Plan2024.pdf", "path": "planes/2024/abc.pdf" },
     *   { "nombre": "Anexo.xlsx",   "path": "planes/2024/def.xlsx" }
     * ]
     */
    public function getDocumentUrlAttribute(): ?array
    {
        if (empty($this->document_path)) {
            return null;
        }

        return collect($this->document_path)->map(function ($file) {
            return [
                'nombre' => $file['nombre'] ?? basename($file['path']),
                'url'    => Storage::url($file['path']),
            ];
        })->all();
    }
}
