<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalSintomas extends Model
{
    protected $table = "reportados";
    protected $fillable =[
        'rpe',
        'fecha_deteccion',
        'area',
        'subarea'
    ];
    public function nota()
    {
        return $this->hasMany(MiSalud::class, 'rpe', 'rpe');
    }
    public function user()
    {
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    }
}
