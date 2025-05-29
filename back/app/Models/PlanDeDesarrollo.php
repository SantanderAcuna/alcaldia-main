<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PlanDeDesarrollo extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'plan_de_desarrollos';

   protected $fillable = [
        'titulo',
        'descripcion',
        'document_path',
        'alcalde_id'
    ];

 

    protected $appends = ['document_url'];

    public function alcalde()
    {
        return $this->belongsTo(Alcalde::class);
    }

    public function getDocumentUrlAttribute()
    {
        return $this->document_path ? Storage::url($this->document_path) : null;
    }




}
