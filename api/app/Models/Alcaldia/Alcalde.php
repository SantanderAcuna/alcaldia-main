<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Alcalde extends User
{
    protected static function booted()
    {
        static::addGlobalScope('solo_alcalde', function (Builder $builder) {
            $builder->where('role', 'alcalde');
        });
    }

    /**
     * Al crear un Funcionario, fija automáticamente el campo `role`.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->role = 'alcalde';
        });
    }
}
