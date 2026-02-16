<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Traits\MemberUpgradeTrait;
use Illuminate\Console\Command;

class FundAttachment extends Command
{
    use MemberUpgradeTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fund:attachment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (User::whereNull('is_banned')->get() as $member) {
            $this->memberUpgrade($member->id);
        }

    }
}
