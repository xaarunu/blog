<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioPendiente extends Model
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
        'division',
        'area',
        'puesto',
        'subarea',
    ];

    protected $table = 'usuario_pendiente';

    public function user() {
        return $this->belongsTo(User::class, 'rpe', 'rpe');
    }
}
