<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentos = [
                         
            ['documento_clave' => 'SA00', 'documento_nombre' => 'Planeacion Operativa', 'documento_seccion' => 'SA','meses_permitidos' => '1,2', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SA01', 'documento_nombre' => 'Difusion de Planeacion Operativa', 'documento_seccion' => 'SA','meses_permitidos' => '1,2,3', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SA02', 'documento_nombre' => 'Difusion de Metas', 'documento_seccion' => 'SA','meses_permitidos' => '1,2,3', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SA03', 'documento_nombre' => 'Difusion de Plan de Negocios', 'documento_seccion' => 'SA','meses_permitidos' => '1,2,3', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            
            ['documento_clave' => 'SB00', 'documento_nombre' => 'Nombramiento RD, Calidad, Ambiental', 'documento_seccion' => 'SB', 'meses_permitidos' => '1', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB01', 'documento_nombre' => 'Programa del SIG', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB02', 'documento_nombre' => 'Presentación de Revisiones por la Dirección', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB03', 'documento_nombre' => 'Presentación de Revisiones por la Dirección', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB04', 'documento_nombre' => 'Comité de Calidad Formalización', 'documento_seccion' => 'SB','meses_permitidos' => '1', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB05', 'documento_nombre' => 'Minuta de Riesgos Operativos', 'documento_seccion' => 'SB', 'meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB06', 'documento_nombre' => 'FODA y partes interesadas', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB07', 'documento_nombre' => 'Difusiones Reunión o Plática', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB08', 'documento_nombre' => 'Reporte de No Conformidades', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB09', 'documento_nombre' => 'Desempeño Ambiental', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB10', 'documento_nombre' => 'Desempeño de SST', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB11', 'documento_nombre' => 'Difusión de resultados de SICLO', 'documento_seccion' => 'SB','meses_permitidos' => '1,2', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB12', 'documento_nombre' => 'Difusión del Program del SIG', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB13', 'documento_nombre' => 'Minutas de Revisión por la Dirección', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB14', 'documento_nombre' => 'Programa de Reuniones de Comité de Calidad', 'documento_seccion' => 'SB','meses_permitidos' => '1', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB15', 'documento_nombre' => 'Difusión de Riesgos Operativos', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB16', 'documento_nombre' => 'Evidencia de las Evaluaciones de Retroalimentación', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '2', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB17', 'documento_nombre' => 'Identificación de Requisitos Legales', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB18', 'documento_nombre' => 'Identificación de Requisitos Legales', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB19', 'documento_nombre' => 'Seguimiento a compromisos Revisión por la Dirección', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB20', 'documento_nombre' => 'Minutas Comité de Calidad', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB21', 'documento_nombre' => 'Plan de atención Riesgos Operativos', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB22', 'documento_nombre' => 'Identificación de Aspectos Ambientales', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB23', 'documento_nombre' => 'Identificación de Peligros y riesgos', 'documento_seccion' => 'SB','meses_permitidos' => '1', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SB23', 'documento_nombre' => 'Seguimiento a compromisos Comité de Calidad', 'documento_seccion' => 'SB','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            
            ['documento_clave' => 'SC00', 'documento_nombre' => 'Asistencia a la RIJ', 'documento_seccion' => 'SC','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SC01', 'documento_nombre' => 'Difusiones Reunión o Plática', 'documento_seccion' => 'SC','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SC02', 'documento_nombre' => 'Difusión de Línea de ética', 'documento_seccion' => 'SC','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SC03', 'documento_nombre' => 'Evidencia de las evaluaciones', 'documento_seccion' => 'SC','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            
            ['documento_clave' => 'SD00', 'documento_nombre' => 'Plan Anual de Control Interno', 'documento_seccion' => 'SD','meses_permitidos' => '1,2', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SD01', 'documento_nombre' => 'Difusión del PACI', 'documento_seccion' => 'SD','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SD02', 'documento_nombre' => 'Plan de Supervisión', 'documento_seccion' => 'SD','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SD03', 'documento_nombre' => 'Difusión de Reuniones y Pláticas', 'documento_seccion' => 'SD','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SD04', 'documento_nombre' => 'Seguimiento a Plan Anual de Control Interno', 'documento_seccion' => 'SD','meses_permitidos' => '0','periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            
            ['documento_clave' => 'SE00', 'documento_nombre' => 'Medición del Desempeño 2023', 'documento_seccion' => 'SE','meses_permitidos' => '1,2', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SE01', 'documento_nombre' => 'Difusión de Metas 2023', 'documento_seccion' => 'SE','meses_permitidos' => '1,2,3', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SE02', 'documento_nombre' => 'Contrato Programa ', 'documento_seccion' => 'SE','meses_permitidos' => '1,2,3', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SE03', 'documento_nombre' => 'Contrato Gestión', 'documento_seccion' => 'SE','meses_permitidos' => '1,2,3', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SE04', 'documento_nombre' => 'Difusión de indicadores', 'documento_seccion' => 'SE','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SE05', 'documento_nombre' => 'Segumiento de Indicadores', 'documento_seccion' => 'SE','meses_permitidos' => '0', 'periodicidad' => '1', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX'],
            ['documento_clave' => 'SE06', 'documento_nombre' => 'Difusión de Contrato Programa ', 'documento_seccion' => 'SE','meses_permitidos' => '1,2,3', 'periodicidad' => '0', 'rpe_creador' =>'ADMIN', 'created_at' => now(), 'updated_at' => now(), 'division' => 'DX', 'area' => 'DX', 'subarea' => 'DX']
        ];

        DB::table('tipo_documento')->insert($documentos);
    }
}
