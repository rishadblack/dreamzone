<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AttachedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $Fund;

    public function __construct($Fund)
    {
        $this->Fund = $Fund;
    }

    public function build()
    {
        return $this->subject('Congratulation Your Fund Attached Successfully')->markdown('emails.attached');
    }
}
