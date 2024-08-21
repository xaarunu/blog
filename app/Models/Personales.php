<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personales extends Model
{
    use HasFactory;
    protected $fillable =  [
    'rpe',
    'cirugia',
    'vacuna',
    'fecha_vacuna',
    'inmunizaciones',
    'area',
    'subarea',
    'herencia',
    'tabaquismo',
    'alcholismo',
    'toxicomanias',
    'nss',
    'unidad_medica',
    'fecha_nacimiento',
    'sexo',
    'altura',
    'peso',
    'imc',
    'cintura',
    'cadera',
    'presionSis',
    'presionDia',
    'glucosa',
    'alergias',
    'tipo',
    'observaciones',
    'diagnostico',
    'tratamiento',
    ];
    public function user()
    {
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    }
}
