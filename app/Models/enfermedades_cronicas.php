<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enfermedades_cronicas extends Model
{
    use HasFactory;

    protected $fillable =  [
        'nombre',
    ];

    public function usuarios()
    {
        return $this->hasMany(UsuarioEnfermedad::class, 'enfermedades_cronicas_id');
    }
}
