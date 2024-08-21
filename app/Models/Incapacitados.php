<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incapacitados extends Model
{
    protected $table = "incapacitados";
    protected $fillable =[
        'rpe',
        'fecha',
        'area',
        'subarea',
        'attended'
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
