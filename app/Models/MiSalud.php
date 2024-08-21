<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiSalud extends Model
{
    use HasFactory;
    protected $fillable =  [
        'rpe',
        'fecha_nacimiento',
        'sexo',
        'fecha',
        'hora',
        'altura',
        'peso',
        'imc',
        'cintura',
        'cadera',
        'presionSis',
        'presionDia',
        'temperatura',
        'saturacion',
        'glucosa',
        'cardiaca',
        'respiratoria',
        'alergias',
        'tipo',
        'observaciones',
        'diagnostico',
        'tratamiento',
    ];

    public function archivos()
    {
        return $this->hasMany(Archivo::class,'mi_salud_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    }
}
