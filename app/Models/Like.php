<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Define los campos que se pueden asignar masivamente
    protected $fillable = [
        'rpe',
        'blog_id',
        'liked',
    ];

    // Define la relación con el modelo Blog
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    // Define la relación con el modelo User (si deseas)
    public function user()
    {
        return $this->belongsTo(User::class, 'rpe', 'rpe');
    }

    
}
