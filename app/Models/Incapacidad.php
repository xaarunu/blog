<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incapacidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificado',
        'tipo',
        'ramo_de_seguro',
        'dias_autorizados',
        'dias_acumulados',
        'fecha_inicio',
        'fecha_fin',
        'nombre_doctor',
        'matricula_doctor',
        'rpe',
        'subarea',
        'diagnostico',
        'observaciones',
        'archivo',
        'estatus',
        'padecimiento',
        'umf_id',
        'consultorio',
        'turno'
    ];

    protected $table = 'incapacidades';

    public function user()
    {
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    }

    public function file()
    {
        return $this->hasOne(ArchivoGeneral::class, 'id', 'archivo');
    }
    public function sub()
    {
        return $this->hasOne(Subarea::class, 'subarea_clave', 'subarea');
    }

    public function padecimientos()
    {
        return $this->belongsTo(Padecimiento::class, 'padecimiento', 'id')
                ->orderBy('padecimiento_nombre', 'asc');
    }

    public function umf()
    {
        return $this->hasOne(UnidadesMedicas::class, 'id', 'umf_id');
    }
}
