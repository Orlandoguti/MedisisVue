<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    //Public Variables 
    public $subject = 'Mensaje de Contactos';
    //public $email;
    public $contenido;
 /**
     * Build the message.
     *
     * @return void
     */
    //Array $data received from EmailController->sendEmail
    public function __construct($contenido)
    {
        $this->contenido  = $contenido;
        //$this->email    = $data['email'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    //Sent to the view in blade.php format in /views/emails/sendEmail.blade.php
    //with all public variables
    
    public function build()
    {
        return $this->view('emails.sendEmail');
    }
}
