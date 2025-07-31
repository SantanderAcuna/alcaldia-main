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

    public function documentos()
    {
        return $this->hasMany(PlanDocumentos::class);
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
        $paths = $this->document_path;

        if (empty($paths)) {
            return null;
        }

        return collect($paths)
            ->map(function ($file) {
                // Si $file es string, lo tratamos como ruta
                if (is_string($file)) {
                    $path = $file;
                    $name = basename($file);
                } elseif (is_array($file)) {
                    $path = $file['path'] ?? '';
                    $name = $file['nombre'] ?? basename($path);
                } else {
                    // Otro caso inesperado, lo descartamos
                    return null;
                }

                if (! $path) {
                    return null;
                }

                return [
                    'nombre' => $name,
                    'url'    => Storage::url($path),
                ];
            })
            ->filter()     // elimina nulls
            ->values()     // reindexa
            ->all();
    }
}
