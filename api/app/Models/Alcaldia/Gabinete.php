<?php

namespace App\Models\Alcaldia;

use App\Models\Usuario\Perfil;
use App\Models\Usuario\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gabinete extends Model
{
    use HasFactory;

    protected $table = 'gabinetes';

    protected $fillable = [
        'user_id',
        'dependencia_id',
        'perfil_id',
        'fecha_inicio',
        'fecha_fin',
        'cargo',
        'actual',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'actual' => 'boolean',
    ];

    /**
     * Usuario asignado al gabinete.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Dependencia asociada al gabinete.
     *
     * @return BelongsTo
     */
    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    /**
     * Perfil relacionado con el gabinete.
     *
     * @return BelongsTo
     */
    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'dependencia_id');
    }


    protected static function newFactory()
    {
        return \Database\Factories\GabineteFactory::new();
    }
    //
}
