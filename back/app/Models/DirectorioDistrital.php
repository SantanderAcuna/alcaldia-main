<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirectorioDistrital extends Model
{
    /** @use HasFactory<\Database\Factories\DirectorioDistritalFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'directorio_distritals';

    protected $fillable = [
        'nombre',
        'funcionario',
        'correo',
        'red_social',
        'tipo_entidad'
    ];

    protected $casts = [
        'contactos' => 'array',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipoEntidad()
    {
        return $this->belongsTo(TipoEntidad::class);
    }

    public function foto()
    {
        return $this->belongsTo(Galeria::class, 'foto_id');
    }

    public function scopeConRelaciones($query)
    {
        return $query->with(['categoria', 'tipoEntidad', 'foto']);
    }

    public function setContactosAttribute($value)
    {
        $this->validateContactos($value);
        $this->attributes['contactos'] = json_encode($value);
    }

    protected function validateContactos($contactos)
    {
        $validator = validator($contactos, [
            'telefonos' => 'array',
            'telefonos.*' => 'string|max:20',
            'redes_sociales' => 'array',
            'redes_sociales.*.nombre' => 'required|string',
            'redes_sociales.*.url' => 'required|url'
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
    }
}
