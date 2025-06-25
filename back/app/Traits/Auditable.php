<?php

namespace App\Traits;

use App\Models\Auditoria;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    public static function bootAuditable(): void
    {
        // Cuando se crea
        static::created(function ($model) {
            Auditoria::create([
                'modelo'     => get_class($model),
                'modelo_id'  => $model->id,
                'accion'     => 'creado',
                'cambios'    => $model->getAttributes(),
                'usuario'    => Auth::check() ? Auth::user()->name : 'sistema',
            ]);
        });

        // Cuando se actualiza
        static::updated(function ($model) {
            $cambios = [];

            foreach ($model->getChanges() as $campo => $nuevoValor) {
                $anterior = $model->getOriginal($campo);
                if ($anterior !== $nuevoValor) {
                    $cambios[$campo] = [
                        'antes'   => $anterior,
                        'despues' => $nuevoValor
                    ];
                }
            }

            if (!empty($cambios)) {
                Auditoria::create([
                    'modelo'     => get_class($model),
                    'modelo_id'  => $model->id,
                    'accion'     => 'actualizado',
                    'cambios'    => $cambios,
                    'usuario'    => Auth::check() ? Auth::user()->name : 'sistema',
                ]);
            }
        });

        // Cuando se elimina
        static::deleted(function ($model) {
            Auditoria::create([
                'modelo'     => get_class($model),
                'modelo_id'  => $model->id,
                'accion'     => 'eliminado',
                'cambios'    => $model->getOriginal(),
                'usuario'    => Auth::check() ? Auth::user()->name : 'sistema',
            ]);
        });
    }
}
