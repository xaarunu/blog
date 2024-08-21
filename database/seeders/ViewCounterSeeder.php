<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViewCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paginas=[
            ['pagina'=>'evidencias','visitas'=>'0'],
            ['pagina'=>'rijs','visitas'=>'0'],
            ['pagina'=>'ev5s','visitas'=>'0'],
            ['pagina'=>'siva','visitas'=>'0'],
            ['pagina'=>'bienestar','visitas'=>'0'],
            ['pagina'=>'stock1','visitas'=>'0'],
            ['pagina'=>'usuarios','visitas'=>'0'],
            ['pagina'=>'resguardos','visitas'=>'0'],
        ];
        
        DB::table('view_counter')->insert($paginas);
    }
}
