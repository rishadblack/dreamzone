<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\CheckMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterConfirmationMail;

class MailCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:check {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Mail::to($this->argument('email'))->queue(new RegisterConfirmationMail(User::find(1), '12345678'));
    }
}
