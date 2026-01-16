<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterConfirmationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $User;
    public $password;

    public function __construct($User, $password)
    {
        $this->User = $User;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Registration confirmation from '.config('app.name'))->markdown('emails.register.confirmation');
    }
}
