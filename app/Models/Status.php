<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = "status";
    protected $fillable =  [
        'codigo',
        'nombre',
    ];

    public function statusSiguientes($rol)
    {
        if($rol == 'admin')
            return $this->belongsToMany('App\Models\Status', 'flujo_status_res', 'status_actual', 'status_siguiente');
        return $this->belongsToMany('App\Models\Status', 'flujo_status_res', 'status_actual', 'status_siguiente')->wherePivot('rol', $rol);
    }

    public function allowed()
    {
        return $this->belongsToMany('App\Models\Status', 'flujo_status_res', 'status_actual', 'status_siguiente');
    }

    public function getFlujo()
    {
        return $this->hasMany('App\Models\FlujoStatusRes', 'status_siguiente');
    }
}
