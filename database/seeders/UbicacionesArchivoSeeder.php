<?php

namespace Database\Seeders;

use App\Models\UbicacionesArchivo;
use Illuminate\Database\Seeder;

class UbicacionesArchivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UbicacionesArchivo::create(['carpeta' => 'storage/audiometrias/', 'categoria' => 'audiometrias']);
        UbicacionesArchivo::create(['carpeta' => 'storage/incapacidades/', 'categoria' => 'incapacidades']);
    }
}
