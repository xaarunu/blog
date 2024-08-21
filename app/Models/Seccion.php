<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = "secciones";
    protected $fillable =  [
        'rpe',
        'division',
        'area',
        'subarea',
        'clave',
        'seccion_clave',
        'seccion_nombre',
        'periodicidad',
        'meses_permitidos'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
