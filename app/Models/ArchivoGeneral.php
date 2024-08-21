<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoGeneral extends Model
{
    use HasFactory;

    protected $table = 'archivos_generales';

    protected $fillable = ['id_ruta', 'hash', 'nombre_archivo', 'tipo_archivo'];

    public function pathDir()
    {
        return $this->hasOne(UbicacionesArchivo::class, 'id', 'id_ruta');
    }

    public function extension() {
        return $this->hasOne(FileType::class, 'id', 'tipo_archivo');
    }

    public function getFilePath() {
        return $this->pathDir->carpeta . $this->hash . $this->extension->extension;
    }
}
