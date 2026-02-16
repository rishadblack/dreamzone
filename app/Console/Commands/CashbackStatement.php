<?php
namespace App\Console\Commands;

use App\Models\Income;
use App\Models\MemberTree;
use App\Models\Point;
use Illuminate\Console\Command;

class CashbackStatement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cashback:statement';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cashback Commission Statement';

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
        if (now()->day == 15 || now()->isLastOfMonth()) {
            $this->info('Running scheduled cashback statement...');
            $this->purchaseCashback();
        }

        return Command::SUCCESS;
    }

    public function purchaseCashback()
    {
        $getCashbackMembers = MemberTree::whereNotNull('is_cashback')->get();

        $salesPoint = Point::query()
            ->whereType(2)
            ->whereFlow(2)
            ->whereDate('created_at', '>=', now()->subDays('15')->format('Y-m-d'))
            ->whereDate('created_at', '<=', now()->format('Y-m-d'))->sum('value');

        $cashbackBonusAmount = $salesPoint * config('mlm.income_list.5.percentage') / 100;

        if ($getCashbackMembers->count() > 0 && $salesPoint > 0) {
            $cashbackBonusNetAmount = $cashbackBonusAmount / $getCashbackMembers->count();

            foreach ($getCashbackMembers as $key => $getCashbackMember) {
                if (! Income::whereType(config('mlm.income_list.5.income_type'))
                    ->whereDate('created_at', now()->format('Y-m-d'))
                    ->whereUserId($getCashbackMember->user_id)->exists() && $cashbackBonusNetAmount > 0) {

                    Income::create([
                        'user_id' => $getCashbackMember->user_id,
                        'parent_id' => $getCashbackMember->user_id,
                        'amount' => $cashbackBonusNetAmount,
                        'net_amount' => $cashbackBonusNetAmount,
                        'wallet_type' => 1,
                        'flow' => 1,
                        'type' => config('mlm.income_list.5.income_type'),
                        'generated_by' => $getCashbackMember->user_id,
                        'status' => 1,
                        'details' => [
                            'total_sales_point' => $salesPoint,
                            'total_cashback_amount' => $cashbackBonusAmount,
                            'total_cashback_achiever' => $getCashbackMembers->count(),
                        ],
                    ]);

                }
            }

            $this->info('Member ' . $getCashbackMember->user_id . ' has been updated.');
        }

        $this->info('Cashback Commission Completed.');
    }
}
