<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlujoStatusRes extends Model
{
    use HasFactory;
    protected $table = "flujo_status_res";
    protected $fillable =  [
        'status_actual',
        'status_siguiente',
        'rol',
    ];



}
