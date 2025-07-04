<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolUser extends Pivot
{
    use HasFactory;
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
