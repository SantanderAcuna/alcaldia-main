<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolUser extends Pivot
{
    protected $table = 'rol_user';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['role_id', 'user_id'];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'role_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
