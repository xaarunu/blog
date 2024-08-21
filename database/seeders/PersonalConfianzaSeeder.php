<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonalConfianza;
use Illuminate\Support\Facades\DB;

class PersonalConfianzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pconf = [
            //Hidalgo
            ['rpe' => '9C30L', 'area' => 'DX14'],
            ['rpe' => '9FVPH', 'area' => 'DX14'],
            ['rpe' => '9JJAV', 'area' => 'DX14'],
            ['rpe' => '9C00G', 'area' => 'DX14'],
            ['rpe' => '9C30B', 'area' => 'DX14'],
            ['rpe' => '9MAAH', 'area' => 'DX14'],
            ['rpe' => '9M2C0', 'area' => 'DX14'],
            ['rpe' => '9N1C6', 'area' => 'DX14'],
            ['rpe' => 'G79AB', 'area' => 'DX14'],
            ['rpe' => 'G78A5', 'area' => 'DX14'],
            ['rpe' => '9MAE3', 'area' => 'DX14'],
            ['rpe' => 'G79A0', 'area' => 'DX14'],
            //Juarez
            ['rpe' => '9BBXC', 'area' => 'DX15'],
            ['rpe' => '9C00T', 'area' => 'DX15'],
            ['rpe' => '9MRE1', 'area' => 'DX15'],
            ['rpe' => '9N1BF', 'area' => 'DX15'],
            ['rpe' => 'G78A1', 'area' => 'DX15'],
            ['rpe' => '9K591', 'area' => 'DX15'],
            ['rpe' => '9MACA', 'area' => 'DX15'],
            ['rpe' => 'G917G', 'area' => 'DX15'],
            ['rpe' => '9C30R', 'area' => 'DX15'],
            ['rpe' => '9C00L', 'area' => 'DX15'],
            ['rpe' => '9CD0C', 'area' => 'DX15'],
            ['rpe' => '9NHY6', 'area' => 'DX15'],
            ['rpe' => '9AJ00', 'area' => 'DX15'],
            //Libertad
            ['rpe' => '9MAHV', 'area' => 'DX16'],
            ['rpe' => '9GGWK', 'area' => 'DX16'],
            ['rpe' => '9N1AY', 'area' => 'DX16'],
            ['rpe' => '9N1CK', 'area' => 'DX16'],
            ['rpe' => '9FVPJ', 'area' => 'DX16'],
            ['rpe' => '9GEUM', 'area' => 'DX16'],
            ['rpe' => '9C00R', 'area' => 'DX16'],
            ['rpe' => '9NHYV', 'area' => 'DX16'],
            ['rpe' => 'J473Y', 'area' => 'DX16'],
            ['rpe' => 'G78A6', 'area' => 'DX16'],
            //Reforma
            ['rpe' => '9JJ81', 'area' => 'DX17'],
            ['rpe' => 'G52E6', 'area' => 'DX17'],
            ['rpe' => '9JJJT', 'area' => 'DX17'],
            ['rpe' => '9MA5E', 'area' => 'DX17'],
            ['rpe' => '9N1DG', 'area' => 'DX17'],
            ['rpe' => '9MRFG', 'area' => 'DX17'],
            ['rpe' => '9N1BE', 'area' => 'DX17'],
            ['rpe' => 'G78A5', 'area' => 'DX17'],
            ['rpe' => '9jjny', 'area' => 'DX17'],
            ['rpe' => '9GFVE', 'area' => 'DX17'],
            ['rpe' => 'G52E5', 'area' => 'DX17'],
            ['rpe' => 'G946G', 'area' => 'DX17'],
                //[GalindoGranado]
            ['rpe' => 'G841G', 'area' => 'DX17'],
            //LosAltos
            ['rpe' => '9B604', 'area' => 'DX02'],
            ['rpe' => '9FVP5', 'area' => 'DX02'],
            ['rpe' => '9JJEY', 'area' => 'DX02'],
            ['rpe' => 'G78AP', 'area' => 'DX02'],
            ['rpe' => 'G299G', 'area' => 'DX02'],
            ['rpe' => '9NHYB', 'area' => 'DX02'],
                //[TejedaMartinez]
            //Chapala
            ['rpe' => '9EFGW', 'area' => 'DX07'],
            ['rpe' => 'G54EF', 'area' => 'DX07'],
            ['rpe' => '9M2EC', 'area' => 'DX07'],
            ['rpe' => '9N1CH', 'area' => 'DX07'],
            ['rpe' => '9B5XD', 'area' => 'DX07'],
            ['rpe' => '9JJK3', 'area' => 'DX07'],
            ['rpe' => '9JJEW', 'area' => 'DX07'],
            ['rpe' => '9M2E2', 'area' => 'DX07'],
            ['rpe' => '9NHY8', 'area' => 'DX07'],
            ['rpe' => 'B762T', 'area' => 'DX07'],
            ['rpe' => 'G79A5', 'area' => 'DX07'],
            ['rpe' => '9JJAT', 'area' => 'DX07'],
            ['rpe' => 'G78AF', 'area' => 'DX07'],
            //Cienega
            ['rpe' => '9GDTJ', 'area' => 'DX03'],
            ['rpe' => '9NHYA', 'area' => 'DX03'],
            ['rpe' => '9MA4J', 'area' => 'DX03'],
            ['rpe' => '9CD0M', 'area' => 'DX03'],
            ['rpe' => '9JJKJ', 'area' => 'DX03'],
            ['rpe' => 'G52ED', 'area' => 'DX03'],
            ['rpe' => '9MREC', 'area' => 'DX03'],
            //Costa
            ['rpe' => '9AHXH', 'area' => 'DX05'],
            ['rpe' => '9MA9D', 'area' => 'DX05'],
            ['rpe' => '9MRE0', 'area' => 'DX05'],
            ['rpe' => '9NHY9', 'area' => 'DX05'],
            ['rpe' => '9BBXK', 'area' => 'DX05'],
                //DueñasPonce
            ['rpe' => 'G864G', 'area' => 'DX05'],
            //Minas
            ['rpe' => '9GCRG', 'area' => 'DX06'],
            ['rpe' => '9JJC1', 'area' => 'DX06'],
            ['rpe' => '9N1DL', 'area' => 'DX06'],
            ['rpe' => '9N1DJ', 'area' => 'DX06'],
            ['rpe' => '9N1DN', 'area' => 'DX06'],
            ['rpe' => 'G858G', 'area' => 'DX06'],
            ['rpe' => '9MRF5', 'area' => 'DX06'],
            ['rpe' => 'J931Y', 'area' => 'DX06'],
            ['rpe' => 'G854G', 'area' => 'DX06'],
            ['rpe' => '9N1CL', 'area' => 'DX06'],
            //Santiago
            ['rpe' => '9C80X', 'area' => 'DX11'],
                //PinedoMontoya
                //CanoHernandez
            ['rpe' => '9GHX1', 'area' => 'DX11'],
            ['rpe' => '9NJ0T', 'area' => 'DX11'],
            ['rpe' => '9M2HD', 'area' => 'DX11'],
            //Tepic
            ['rpe' => '9C305', 'area' => 'DX12'],
            ['rpe' => '9GL2V', 'area' => 'DX12'],
            ['rpe' => '9B6B5', 'area' => 'DX12'],
            ['rpe' => '9JJAG', 'area' => 'DX12'],
            ['rpe' => '9FWR8', 'area' => 'DX12'],
                //RioseguraCorrea
            ['rpe' => '9FWR7', 'area' => 'DX12'],
            ['rpe' => '9MA4E', 'area' => 'DX12'],
            ['rpe' => '9NHYY', 'area' => 'DX12'],
            //Vallarta
            ['rpe' => '9C600', 'area' => 'DX13'],
            ['rpe' => '9FVPL', 'area' => 'DX13'],
            ['rpe' => '9JJLU', 'area' => 'DX13'],
            ['rpe' => '9EFHK', 'area' => 'DX13'],
            ['rpe' => '9EFH7', 'area' => 'DX13'],
                //MiramontesMacias
            ['rpe' => '9NJ0W', 'area' => 'DX13'],
                //BravoRodriguez
            ['rpe' => '9GCRE', 'area' => 'DX13'],
                //MezaNegrete
            ['rpe' => '9MRF0', 'area' => 'DX13'],
            //Zapotlan
            ['rpe' => '9C90F', 'area' => 'DX04'],
            ['rpe' => '9CE0W', 'area' => 'DX04'],
            ['rpe' => '9B67E', 'area' => 'DX04'],
            ['rpe' => '9B693', 'area' => 'DX04'],
            ['rpe' => '9M2JB', 'area' => 'DX04'],
            ['rpe' => '9M2HE', 'area' => 'DX04'],
            ['rpe' => '9N1DH', 'area' => 'DX04'],
            ['rpe' => '9C909', 'area' => 'DX04'],
            ['rpe' => '9M2J8', 'area' => 'DX04'],
            ['rpe' => '9EFLE', 'area' => 'DX04'],
        ];
        DB::table('personal_confianza')->insert($pconf);

        $personalConfianza = PersonalConfianza::all();

        foreach($personalConfianza as $usuario)
        {
            $datosUser = $usuario->getDatosuser;
            $datosUser->confianza = 1;
            $datosUser->save();
        }
    }
}
