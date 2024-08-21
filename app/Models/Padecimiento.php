<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padecimiento extends Model
{
    use HasFactory;
    protected $table = 'padecimientos';

    protected $fillable = [
        'padecimiento_nombre',
    ];

    public function incapacidades()
    {
        return $this->hasMany(Incapacidad::class, 'padecimiento', 'id')
                ->orderBy('padecimiento_nombre', 'asc');
    }

}
