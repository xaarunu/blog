<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionesArchivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'carpeta',
        'categoria'
    ];

    public $timestamps = false;
}
