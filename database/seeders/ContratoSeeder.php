<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contratos;
class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contratos::create(['cl_tipco' => '1', 'tipocontrato' => 'PERMANENTE CONFIANZA']);
        Contratos::create(['cl_tipco' => '2', 'tipocontrato' => 'TEMPORAL CONFIANZA']);
        Contratos::create(['cl_tipco' => '3', 'tipocontrato' => 'JUBILADO']);
        Contratos::create(['cl_tipco' => '6', 'tipocontrato' => 'PERMANENTE SINDICALIZADO']);
        Contratos::create(['cl_tipco' => '7', 'tipocontrato' => 'TEMPORAL SINDICALIZADO']);
    }
}
