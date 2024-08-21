<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiometria extends Model
{
    use HasFactory;

    protected $fillable = [
        'rpe',
        'fecha_toma',
        'oido_izquierdo',
        'oido_derecho',
        'archivo'
    ];

    public function user()
    {
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    }

    public function file()
    {
        return $this->hasOne(ArchivoGeneral::class, 'id', 'archivo');
    }

    public function resultadoIzquierdo() {
        return $this->hasOne(ResultadoAudiometria::class, 'id', 'oido_izquierdo');
    }

    public function resultadoDerecho() {
        return $this->hasOne(ResultadoAudiometria::class, 'id', 'oido_derecho');
    }
}
