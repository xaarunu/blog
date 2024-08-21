<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioUnidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'rpe',
        'unidad',
        'consultorio',
        'turno',
    ];
    public $timestamps = false;
    protected $primaryKey = 'rpe';
    protected $table = 'usuario_unidad';
}
