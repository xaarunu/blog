<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CambiarContraseñaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $expiration;
    public $user_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code = '******', $expiration = '00/00/00 00:00:00', $user_name = '')
    {
        $this->code = $code;
        $this->expiration = $expiration;
        $this->user_name = $user_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.authcode')->subject('Restablecer Contraseña')->from(env('MAIL_FROM_ADDRESS'),'CFE Bienestar');
    }
}
