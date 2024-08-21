<?php

namespace Database\Seeders;

use App\Models\ResultadoAudiometria;
use Illuminate\Database\Seeder;

class ResultadosAudiometriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ResultadoAudiometria::create(['diagnostico' => 'AUDICIÓN NORMAL']);
        ResultadoAudiometria::create(['diagnostico' => 'HIPOACUSIA LEVE']);
        ResultadoAudiometria::create(['diagnostico' => 'HIPOACUSIA MODERADA']);
    }
}
