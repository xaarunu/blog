<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuario_enfermedad extends Model
{
    use HasFactory;

    protected $fillable =  [
        'enfermedades_cronicas_id',
        'fecha_detectada',
        'rpe',
    ];

    public function enfermedadCronica()
    {
        return $this->belongsTo(enfermedades_cronicas::class, 'enfermedades_cronicas_id');
        
    }

    public function user()
    { 
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    }
}
