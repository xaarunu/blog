<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Puesto;

class PuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Puesto::create(['nombre_puesto' => 'PERSONAL']);
        Puesto::create(['nombre_puesto' => 'JEFE DE OFICINA CAC']);
        Puesto::create(['nombre_puesto' => 'JEFE DE PROCESO SUSTANTIVOS']);
        Puesto::create(['nombre_puesto' => 'JEFE DE PROCESO ADMINISTRATIVO']);
        Puesto::create(['nombre_puesto' => 'JEFE DE DEPARTAMENTO']);
        Puesto::create(['nombre_puesto' => 'SUPERVISOR OFICINAS']);
        Puesto::create(['nombre_puesto' => 'SUPERINTENDENTE']);
        Puesto::create(['nombre_puesto' => 'GERENTE']);
        Puesto::create(['nombre_puesto' => 'SECRETARIO DE TRABAJO']);
    }
}
