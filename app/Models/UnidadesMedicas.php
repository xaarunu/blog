<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesMedicas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'municipio',
    ];

    protected $table = 'unidades_medicas';
    
    public function users()
    {
        return $this->belongsToMany(
            Datosuser::class,   //Modelo al que se quiere llegar
            'usuario_unidad',   //nombre de la tabla pivote
            'unidad',           //columna en la tabla pivote que hace referencia a unidad médica
            'rpe',              //columna en la tabla pivote que hace referencia al usuario
            'id',               //columna de la tabla unidades_medicas
            'rpe'               //columna de la tabla de usuarios
        );
    }

}
