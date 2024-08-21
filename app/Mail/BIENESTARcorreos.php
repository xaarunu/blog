<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BIENESTARcorreos extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $dias_acumulados;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;
    public $ramo_de_seguro;
    public $nombre_doctor;
    public $vista;

    public function __construct($dias_acumulados, $nombre, $fecha_inicio, $fecha_fin,
    $ramo_de_seguro, $nombre_doctor = null, $vista)
    {
        $this->dias_acumulados = $dias_acumulados;
        $this->nombre = $nombre;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->ramo_de_seguro = $ramo_de_seguro;
        $this->nombre_doctor = $nombre_doctor;
        $this->vista = $vista;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->vista == 'incapacidad'){
            return $this->view('mail.email')->with([
                'dias_acumulados' => $this->dias_acumulados,
                'nombre' => $this->nombre,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'ramo_de_seguro' => $this->ramo_de_seguro,
                'nombre_doctor' => $this->nombre_doctor,
            ])
            //->subject($titulo)
            ->from(env('MAIL_FROM_ADDRESS'),'BIENESTAR');

        }elseif($this->vista == 'reporte'){
            return $this->view('mail.email')->with([
                'fechaAtendido' => $this->dias_acumulados,
                'nombre' => $this->nombre,
                'fechaDeteccion' => $this->ramo_de_seguro,
            ])
            //->subject($titulo)
            ->from(env('MAIL_FROM_ADDRESS'),'BIENESTAR');
        }
    }
}
