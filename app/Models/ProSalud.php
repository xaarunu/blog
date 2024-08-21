<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProSalud extends Model
{
    use HasFactory;
    protected $table = "prosalud";
    protected $dates = ['deleted_at'];
    protected $fillable =[
            'rpe',
            'nombre',
            'fecha_Toma',
            'edad',
            'glucosa_resultado',
            'glucosa_unidades',
            'glucosa_referencia',
            'trigliceridos_resultado',
            'trigliceridos_unidades',
            'trigliceridos_referencia',
            'colesterol_resultado',
            'colesterol_unidades',
            'colesterol_referencia',
            'hemoglobina_resultado',
            'hemoglobina_unidades',
            'hemoglobina_referencia',
            'leucocitos_resultado',
            'leucocitos_unidades',
            'leucocitos_referencia',
            'plaquetas_resultado',
            'plaquetas_unidades',
            'plaquetas_referencia',
            'zona',
    ];

    public function usuario()
    {
        return $this->belongsTo(Datosuser::class, 'rpe', 'rpe');
    } 
    public function area()
    {
        return  $this->hasOne(Area::class, 'area_clave', 'zona');
    }
}
