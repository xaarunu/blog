<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisioneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Diviciones = [
            ['division_clave' => 'DX', 'division_nombre' => 'Jalisco'],  
            ['division_clave' => 'DA', 'division_nombre' => 'Baja California'], 
            ['division_clave' => 'DB', 'division_nombre' => 'Noroeste'],   
            ['division_clave' => 'DC', 'division_nombre' => 'Norte'],
            ['division_clave' => 'DD', 'division_nombre' => 'Golfo Norte'],
            ['division_clave' => 'DF', 'division_nombre' => 'Centro Occidente'],
            ['division_clave' => 'DG', 'division_nombre' => 'Centro Sur'],   
            ['division_clave' => 'DJ', 'division_nombre' => 'Oriente'],   
            ['division_clave' => 'DK', 'division_nombre' => 'Sureste'],
            ['division_clave' => 'DL', 'division_nombre' => 'Valle de México Norte'],
            ['division_clave' => 'DM', 'division_nombre' => 'Valle de México Centro'],
            ['division_clave' => 'DN', 'division_nombre' => 'Valle de México Sur'],
            ['division_clave' => 'DP', 'division_nombre' => 'Bajio'],
            ['division_clave' => 'DU', 'division_nombre' => 'Golfo Centro'],
            ['division_clave' => 'DV', 'division_nombre' => 'Centro Oriente'],
            ['division_clave' => 'DW', 'division_nombre' => 'Peninsular'],
            ['division_clave' => 'D2', 'division_nombre' => 'Corporativo']
        ];

        DB::table('divisiones')->insert($Diviciones);

    }
}
