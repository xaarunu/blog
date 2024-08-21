<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicadorSwitch extends Model
{
    use HasFactory;

    protected $table = 'indicadores_switchs';

    protected $fillable = [
        'indicador',
        'encendido'
    ];

    public static function cambiarEstado($id)
    {
        $indicador = self::findOrFail($id); //buscar el indicador por id
        $indicador->encendido = !$indicador->encendido; //invertir el estado del indicador
        $indicador->save(); //guardamos el cambio
        return $indicador; //retornamos el indicador
    }
}
