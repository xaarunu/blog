<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\status;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Status = [
            ['codigo'=> '1', 'nombre' => 'Creado', 'descripcion' => 'Resguardo creado y listo para enviar'],
            ['codigo'=> '2', 'nombre' => 'Enviado para revision', 'descripcion' => 'Resguardo esperando revisión'],
            ['codigo'=> '3', 'nombre' => 'Autorizado', 'descripcion' => 'Resguardo autorizado, esperando acciones'],
            ['codigo'=> '4', 'nombre' => 'Enviar de nuevo', 'descripcion' => 'Resguardo regresado para realizar correcciones'],
            ['codigo'=> '5', 'nombre' => 'Rechazado', 'descripcion' => 'Se rechazó el resguardo'],
            ['codigo'=> '6', 'nombre' => 'Cancelado', 'descripcion' => 'Resguardo cancelado'],
            ['codigo'=> '7', 'nombre' => 'Baja', 'descripcion' => 'Resguardo en proceso de baja'],
            ['codigo'=> '8', 'nombre' => 'Reasignado', 'descripcion' => 'Esperando asignación del resguardador físico'],
            ['codigo'=> '9', 'nombre' => 'Asignacion Solicitada', 'descripcion' => 'Resguardador asignado, esperando autorizacion'],
            ['codigo'=> '10', 'nombre' => 'Corregido', 'descripcion' => 'Corregido y enviado de nuevo para nueva revisión'],
            ['codigo'=> '11', 'nombre' => 'Asignación autorizada', 'descripcion' => 'Resguardador autorizado y asignado al resguardo'],
            ['codigo'=> '12', 'nombre' => 'Asignación cancelada', 'descripcion' => 'Resguardador no aprovado'],
            ['codigo'=> '13', 'nombre' => 'Solicitar Baja', 'descripcion' => 'Solicitud de baja enviada con dictamen y formato13'],
            ['codigo'=> '14', 'nombre' => 'Baja autorizada', 'descripcion' => 'Solicitud de baja autorizada'],
            //['codigo'=> '15', 'nombre' => 'Baja cancelada', 'descripcion' => 'Solicitud de baja no autorizada'],
        ];
        DB::table('status')->insert($Status);
    }
}