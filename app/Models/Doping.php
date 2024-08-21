<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doping extends Model
{
    use HasFactory;
    protected $table = 'dopings';
    protected $fillable =  [
        'nombre',
        'rpe',
        'resultado',
        'zona',
    ];
}
