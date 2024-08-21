<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RolPrestado extends Model
{
    use HasFactory;

    protected $table = 'roles_prestados';

    protected $fillable = [
        'id_entrega',
        'id_rol'
    ];

    public $incrementing = false;
    public $timestamps = false;

    public function entrega() {
        return $this->belongsTo(EntregaRecepcion::class, 'id_entrega', 'id');
    }

    public function info() {
        return $this->belongsTo(Role::class, 'id_rol', 'id');
    }
}
