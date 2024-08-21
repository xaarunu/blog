<?php

namespace Database\Seeders;

use App\Models\enfermedades_cronicas;
use Illuminate\Database\Seeder;

class enfermedadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        enfermedades_cronicas::create(['nombre' => 'Diabetes tipo 1']);
        enfermedades_cronicas::create(['nombre' => 'Diabetes tipo 2']);
        enfermedades_cronicas::create(['nombre' => 'Enfermedad cardiovascular']);
        enfermedades_cronicas::create(['nombre' => 'Enfermedad pulmonar obstructiva crónica']);
        enfermedades_cronicas::create(['nombre' => 'Artritis reumatoide']);
        enfermedades_cronicas::create(['nombre' => 'Asma']);
        enfermedades_cronicas::create(['nombre' => 'Enfermedad renal crónica']);
        enfermedades_cronicas::create(['nombre' => 'Enfermedad de Alzheimer']);
        enfermedades_cronicas::create(['nombre' => 'Enfermedad de Parkinson']);
        enfermedades_cronicas::create(['nombre' => 'Lupus eritematoso sistémico (LES)']);
        enfermedades_cronicas::create(['nombre' => 'Enfermedad de Crohn']);
        enfermedades_cronicas::create(['nombre' => 'COVID']);
        enfermedades_cronicas::create(['nombre' => 'Influenza']);
    }
}
