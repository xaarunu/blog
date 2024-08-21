<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $secciones = [

            ['seccion_clave' => 'SA', 'seccion_nombre' => 'PEO', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now()],
            ['seccion_clave' => 'SB', 'seccion_nombre' => 'SIG', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now()],
            ['seccion_clave' => 'SC', 'seccion_nombre' => 'ETICA', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now()],
            ['seccion_clave' => 'SD', 'seccion_nombre' => 'SCI', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now()],
            ['seccion_clave' => 'SE', 'seccion_nombre' => 'MED', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now()],
            
        ];

        DB::table('secciones')->insert($secciones);
    }
}
