<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlujoStatusResSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                /*
        1-Creado
        2-En revision
        3-Autorizado
        4-Correccion
        10-Corregido
        5-Rechazado
        6-Cancelado
        7-Baja
        8-Reasignado
        9-Asignado
        */
        $FlujoStatusRes = [
            ['status_actual' => '1', 'status_siguiente' => '2', 'rol' =>'JefeArea'],
            ['status_actual' => '2', 'status_siguiente' => '3', 'rol' =>'JefeDivision'],
            ['status_actual' => '2', 'status_siguiente' => '4', 'rol' =>'JefeDivision'],
            ['status_actual' => '2', 'status_siguiente' => '5', 'rol' =>'JefeDivision'],
            ['status_actual' => '3', 'status_siguiente' => '8', 'rol' =>'JefeArea'],
            ['status_actual' => '4', 'status_siguiente' => '10', 'rol' =>'JefeArea'],
            ['status_actual' => '10', 'status_siguiente' => '3', 'rol' =>'JefeDivision'],
            ['status_actual' => '10', 'status_siguiente' => '4', 'rol' =>'JefeDivision'],
            ['status_actual' => '10', 'status_siguiente' => '5', 'rol' =>'JefeDivision'],
            ['status_actual' => '8', 'status_siguiente' => '9', 'rol' =>'JefeArea'],
            ['status_actual' => '9', 'status_siguiente' => '11', 'rol' =>'JefeDivision'],
            ['status_actual' => '9', 'status_siguiente' => '12', 'rol' =>'JefeDivision'],
            ['status_actual' => '11', 'status_siguiente' => '8', 'rol' =>'JefeArea'],
            ['status_actual' => '8', 'status_siguiente' => '13', 'rol' =>'JefeArea'],
            ['status_actual' => '13', 'status_siguiente' => '14', 'rol' =>'JefeDivision'],
            //['status_actual' => '13', 'status_siguiente' => '15', 'rol' =>'JefeDivision'],
            ];
    
            DB::table('flujo_status_res')->insert($FlujoStatusRes);
    
    }
}
