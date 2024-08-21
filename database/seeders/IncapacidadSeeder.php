<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncapacidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incapacidades')->insert([
            [
                'certificado' => 'CERT001',
                'tipo' => 'Temporal',
                'ramo_de_seguro' => 'Accidente',
                'dias_autorizados' => 7,
                'dias_acumulados' => 7,
                'fecha_inicio' => '2024-08-01',
                'fecha_fin' => '2024-08-08',
                'nombre_doctor' => 'Dr. Juan Perez',
                'matricula_doctor' => 'MD12345',
                'rpe' => '9C2CW',
                'subarea' => 'Subarea 1',
                'diagnostico' => 'Fractura de pierna',
                'observaciones' => 'Paciente en reposo',
                'archivo' => 1, // Valor numérico
                'padecimiento' => 'Fractura',
            ],
            [
                'certificado' => 'CERT002',
                'tipo' => 'Permanente',
                'ramo_de_seguro' => 'Enfermedad',
                'dias_autorizados' => 14,
                'dias_acumulados' => 14,
                'fecha_inicio' => '2024-07-15',
                'fecha_fin' => '2024-07-29',
                'nombre_doctor' => 'Dr. Ana Garcia',
                'matricula_doctor' => 'MD67890',
                'rpe' => '9JJKD',
                'subarea' => 'Subarea 2',
                'diagnostico' => 'Diabetes tipo 2',
                'observaciones' => 'Controlar niveles de glucosa',
                'archivo' => 2, // Valor numérico
                'padecimiento' => 'Diabetes',
            ],
            [
                'certificado' => 'CERT003',
                'tipo' => 'Temporal',
                'ramo_de_seguro' => 'Maternidad',
                'dias_autorizados' => 30,
                'dias_acumulados' => 30,
                'fecha_inicio' => '2024-06-01',
                'fecha_fin' => '2024-06-30',
                'nombre_doctor' => 'Dr. Luis Hernandez',
                'matricula_doctor' => 'MD54321',
                'rpe' => 'USUA1',
                'subarea' => 'Subarea 3',
                'diagnostico' => 'Embarazo',
                'observaciones' => 'Reposo recomendado',
                'archivo' => 3, // Valor numérico
                'padecimiento' => 'Embarazo',
            ],
            [
                'certificado' => 'CERT004',
                'tipo' => 'Temporal',
                'ramo_de_seguro' => 'Accidente',
                'dias_autorizados' => 10,
                'dias_acumulados' => 10,
                'fecha_inicio' => '2024-08-05',
                'fecha_fin' => '2024-08-15',
                'nombre_doctor' => 'Dr. Marta Lopez',
                'matricula_doctor' => 'MD98765',
                'rpe' => '9BBWG',
                'subarea' => 'Subarea 4',
                'diagnostico' => 'Contusión craneal',
                'observaciones' => 'Evaluar signos neurológicos',
                'archivo' => 4, // Valor numérico
                'padecimiento' => 'Contusión',
            ],
            [
                'certificado' => 'CERT005',
                'tipo' => 'Permanente',
                'ramo_de_seguro' => 'Enfermedad',
                'dias_autorizados' => 20,
                'dias_acumulados' => 20,
                'fecha_inicio' => '2024-05-10',
                'fecha_fin' => '2024-05-30',
                'nombre_doctor' => 'Dr. Carlos Martinez',
                'matricula_doctor' => 'MD11223',
                'rpe' => '9JJNY',
                'subarea' => 'Subarea 5',
                'diagnostico' => 'Hipertensión',
                'observaciones' => 'Monitoreo de presión arterial',
                'archivo' => 5, // Valor numérico
                'padecimiento' => 'Hipertensión',
            ],
        ]);
    }
}
