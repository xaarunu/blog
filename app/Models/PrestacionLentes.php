<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestacionLentes extends Model
{
    use HasFactory;

    protected $fillable = [
        'rpe',
        'fecha_asignacion',
        'archivo_id'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    }

    public function archivo()
    {
        return $this->hasOne(ArchivoGeneral::class, 'id', 'archivo_id');
    }
}
