<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'path',
        'name',
        'mime',
        'size'
    ];
}
