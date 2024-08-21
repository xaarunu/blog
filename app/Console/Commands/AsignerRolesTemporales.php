<?php

namespace App\Console\Commands;

use App\Models\EntregaRecepcion;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Output\ConsoleOutput;

class AsignerRolesTemporales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:rolesTemporales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene las entregas de recepción programadas para el día actual
    y realiza los cambios de roles entre los usuarios involucrados.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->output = new ConsoleOutput();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fechaActual = Date('Y-m-d');

        $recepcionesComienzo = EntregaRecepcion::where('fecha_inicio', $fechaActual)->get();
        $recepcionesFin = EntregaRecepcion::where('fecha_final', $fechaActual)->get();

        // Procesar cada "Entrega de recepción" activa que se tiene registrada
        foreach($recepcionesComienzo as $entrega) {
            $this->nuevaAsignacion($entrega);
        }

        // Procesar cada "Entrega de recepción" que termina
        foreach($recepcionesFin as $entrega) {
            $this->entregaFinalizada($entrega);
        }

        return 0;
    }

    public function nuevaAsignacion($entrega) {
        $ausente = $entrega->usuarioAusente->user;
        $receptor = $entrega->usuarioReceptor->user;
        $roles = $entrega->rolesPrestados;

        $this->procesarCambios($ausente, $receptor, $roles);
    }

    public function entregaFinalizada($entrega) {
        $ausente = $entrega->usuarioAusente->user;
        $receptor = $entrega->usuarioReceptor->user;
        $roles = $entrega->rolesPrestados;

        $this->procesarCambios($receptor, $ausente, $roles);
    }

    private function procesarCambios($usuarioOriginal, $usuarioReceptor, $rolesInvolucrados) {
        // Obtener los roles que se trasnferiran en por la ausencia del usuario
        $rolesPrestados = Role::whereIn('id', $rolesInvolucrados->pluck('id_rol'))->get();

        // Verificar que el primer usuario tenga los roles solicitados
        if ($usuarioOriginal->hasAllRoles($rolesPrestados)) {
            $this->intercambiarRoles($usuarioOriginal, $usuarioReceptor, $rolesPrestados);
            $this->info("Se transfieren roles de: $usuarioOriginal->rpe a $usuarioReceptor->rpe correctamente!");
        } else {
            // Obtener que roles no tiene el usuario original, y por tanto la solicitud es incorrecta
            $roles = $rolesPrestados->diff($usuarioOriginal->roles)->pluck('name');

            $this->error("Error al intentar transferir: $roles de: $usuarioOriginal->rpe a $usuarioReceptor->rpe");
        }
    }

    private function intercambiarRoles($pierde, $gana, $roles) {
        // Iterar sobre el arreglo de roles para ir removiendo uno por uno
        foreach($roles as $rol)
            $pierde->removeRole($rol);

        // Asignar todos los roles "prestados"
        $gana->assignRole($roles);
    }
}
