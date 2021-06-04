<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class passwordRecovery extends Mailable
{
    use Queueable, SerializesModels;

    //atributos de esta clase de email
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Arg_user)
    {
        $this->user = $Arg_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'nombre_usuario' => $this->user->name,
            'link_reset'     => env('APP_URL') . '/password/' . encrypt
                ($this->user->id) . '/reset',
        ];

        return $this->subject("instaladores NiceTV - reinicio de contraseña")
                    ->view('emails.passwordReset',
                        $data);
    }
}
