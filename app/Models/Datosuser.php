<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Datosuser extends Model
{
    use HasFactory;

    protected $fillable =  [
        'rpe',
        'nombre',
        'paterno',
        'materno',
        'ingreso',
        'antiguedad',
        'contrato',
        'area',
        'puesto',
        'subarea',
        'division',
    ];

    public function setRpeAttribute($value)
    {
        $this->attributes['rpe'] = strtoupper($value);
    }

    public function getNombreCompleto()
    {
        return implode(" ",  $this->only('nombre', 'paterno', 'materno'));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'rpe', 'rpe');
    }

    public function getArea()
    {
        return  $this->hasOne(Area::class, 'area_clave', 'area');
    }

    public function getSubarea()
    {
        return $this->hasOne(Subarea::class, 'subarea_clave', 'subarea');
    }

    public function getDivision()
    {
        return $this->hasOne(Division::class, 'division_clave', 'division');
    }

    public function getDiasVac()
    {
        return $this->hasOne(Dia_vac_disponibles::class, 'rpe', 'rpe');
    }

    public function getSolicitudesVacaciones()
    {
        return $this->hasMany(Solicitudes_vacaciones::class, 'rpe', 'rpe');
    }

    public function vacacionUsuario(){
        return $this->hasOne(Vacacion_Usuario::class, 'rpe', 'rpe');
    }

    public function isInPersonalConfianza()
    {
        if(PersonalConfianza::where('rpe', $this->rpe)->count() > 0)
            return true;
        return false;
    }

    public function scopeHaveAntiquity(){
        return $this->whereNotNull('antiguedad');
    }

    public function contratos(){
        return $this->hasOne(Contratos::class, 'cl_tipco', 'contrato');
    }

    public function unidad_medica()
    {
        return $this->hasOneThrough(
            UnidadesMedicas::class, // Modelo al que se quiere llegar
            UsuarioUnidad::class,   // Modelo pivote
            'rpe',                  // Clave foránea en la tabla usuario_unidad que hace referencia al usuario
            'id',                   // Clave primaria en la tabla unidades_medicas
            'rpe',                  // Atributo de la tabla usuarios que se usará para la relación
            'unidad'                // Clave foránea en la tabla usuario_unidad que hace referencia a la unidad médica
        );
    }

    public function incapacidades()
    {
        return $this->hasMany(Incapacidad::class, 'rpe', 'rpe');
    }

    public function rijSicks()
    {
        return $this->hasMany(RijSick::class, 'user_rpe', 'rpe');
    }
    public function prosalud()
    {
        return $this->hasOne(ProSalud::class, 'rpe', 'rpe');
    }

    public function lentes()
    {
        return $this->hasMany(PrestacionLentes::class, 'rpe', 'rpe');
    }
}
