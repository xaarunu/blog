<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaRecepcion extends Model
{
    use HasFactory;

    protected $table = 'entrega_recepcion';

    protected $fillable = [
        'rpe_ausente',
        'rpe_receptor',
        'fecha_inicio',
        'fecha_final',
        'motivo',
        'id_archivo'
    ];

    public function usuarioAusente() {
        return $this->belongsTo(Datosuser::class, 'rpe_ausente', 'rpe');
    }

    public function usuarioReceptor() {
        return $this->belongsTo(Datosuser::class, 'rpe_receptor', 'rpe');
    }

    public function rolesPrestados() {
        return $this->hasMany(RolPrestado::class, 'id_entrega', 'id');
    }

    public function archivo() {
        return $this->hasOne(ArchivoGeneral::class, 'id', 'id_archivo');
    }
}
