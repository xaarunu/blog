<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 
        'contenido', 
        'rpe',
        'prioridad',
        'fecha_vencimiento',
        'imagen',
        'likes',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'rpe' );
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}
