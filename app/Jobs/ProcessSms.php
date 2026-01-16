<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Http\Controllers\SendSms;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Controllers\SendSmsController;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessSms implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $receiver;
    public $body;
    public $action;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($receiver, $body, $action)
    {
        $this->receiver = $receiver;
        $this->body = $body;
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sendSms = new SendSms();
        $sendSms->setNumber($this->receiver)
            ->setMessage($this->body)
            ->setAction($this->action)
            ->send();
    }
}
