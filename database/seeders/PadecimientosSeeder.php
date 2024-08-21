<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PadecimientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $padecimiento = [           
            ['padecimiento_nombre' => 'Enfermedades Respiratorias'],
            ['padecimiento_nombre' => 'Cirugías-Quirurgicas'],
            ['padecimiento_nombre' => 'Musculoesqueleticas'],
            ['padecimiento_nombre' => 'Gastrointestinales'],
            ['padecimiento_nombre' => 'Urinarias'],
            ['padecimiento_nombre' => 'Lamonológicas'],
            ['padecimiento_nombre' => 'Cronicodegenerativas'],
            ['padecimiento_nombre' => 'Cardiobasculares'],
            ['padecimiento_nombre' => 'Oncológicas'],
            ['padecimiento_nombre' => 'Neuropatías'],
            ['padecimiento_nombre' => 'Psiquiatricas'],
            ['padecimiento_nombre' => 'Neurológicas'],
            ['padecimiento_nombre' => 'Traumatologia-Ortopedia'],
            ['padecimiento_nombre' => 'Inmunologicas'],
            ['padecimiento_nombre' => 'Cardiovasculares'],
            ['padecimiento_nombre' => 'Otros'],            
        ];

        DB::table('padecimientos')->insert($padecimiento);
    }
}
