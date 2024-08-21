<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PadecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('padecimientos')->insert([
            [
                'padecimiento_nombre' => 'Fractura',
            ],
            [
                'padecimiento_nombre' => 'Diabetes',
            ],
            [
                'padecimiento_nombre' => 'Embarazo',
            ],
            [
                'padecimiento_nombre' => 'Contusión',
            ],
            [
                'padecimiento_nombre' => 'Hipertensión',
            ],
        ]);
    }
}
