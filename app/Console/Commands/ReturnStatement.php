<?php

namespace App\Console\Commands;

use App\Models\Fund;
use App\Models\Income;
use App\Models\Statement;
use App\Models\MemberTree;
use Illuminate\Console\Command;

class ReturnStatement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'return:statement';

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

        $this->info('Return Start :' . now()->format('d-m-Y H:i:s'));
        $this->dailyReturn();
        $this->info('Return successfully.');

    }

    public function dailyReturn()
    {
        $Statement = Statement::whereStatus(1)->whereType(1)->whereNull('is_distribute')->whereDate('close_date', '<=', now())->first();
        if ($Statement && $Statement->percentage) {
            $this->info('Return Statement ID: ' . $Statement->id);
            $this->info('Return Statement Close Date: ' . $Statement->close_date->format('d-m-Y'));

            $TotalUpgraded = Fund::whereNotNull('is_attached')->whereNull('is_detached_request')->whereStatus(1)->sum('attached_amount');

            $MemberTree = MemberTree::withSum(['Fund as total_attached' => function ($query) {
                $query->whereNotNull('is_attached')->whereNull('is_detached_request');
            }], 'attached_amount')->with('Package')->get();

            $this->info('Return Attach Amount: ' . $TotalUpgraded);

            $distributeAmount = 0;
            foreach ($MemberTree as $member) {
                if ($member->total_attached > 0 && $member->package_id) {
                    $distributePercent = $Statement->percentage * $member->Package->point_value;
                    $returnNetAmount = $member->total_attached * $distributePercent / 100;

                    if(Income::whereUserId($member->user_id)->whereStatementId($Statement->id)->exists()) {
                        continue;
                    }

                    Income::create([
                        'user_id' => $member->user_id,
                        'parent_id' => $member->user_id,
                        'statement_id' => $Statement->id,
                        'amount' => $returnNetAmount,
                        'charge' => 0,
                        'net_amount' => $returnNetAmount,
                        'wallet_type' => 1,
                        'type' => 2,
                        'flow' => 1,
                        'generated_by' => $member->user_id,
                        'status' => 1,
                    ]);

                    $generationIncome = $returnNetAmount * config('mlm.income_list.4.percentage') / 100;
                    if($member->sponsor_id && $generationIncome > 0) {
                        $this->generationIncome($generationIncome, $member->sponsor_id, $member);
                    }

                    $distributeAmount += $returnNetAmount;
                }
            }
            $Statement->total_amount = $TotalUpgraded;
            $Statement->distribute_amount = $distributeAmount;
            $Statement->is_distribute = now();
            $Statement->save();
        }
        $this->info('Return Generate successfully.');

    }

    public function generationIncome($returnAmount, $SponsorId, $User, $level = 1)
    {
        $memberTree = MemberTree::where('user_id', $SponsorId)->first();
        $sponsorCount = MemberTree::where('sponsor_id', $SponsorId)->count();

        $levelIncome = $returnAmount * config('mlm.generation_income_list.' . $level . '.percentage') / 100;
        $sponsorCountCondition = config('mlm.generation_income_list.' . $level . '.condition');

        if($levelIncome > 0 && $sponsorCount >= $sponsorCountCondition && $memberTree->is_premium) {
            Income::create([
                'user_id' => $SponsorId,
                'parent_id' => $User->id,
                'amount' => $levelIncome,
                'net_amount' => $levelIncome,
                'level' => $level,
                'wallet_type' => 1,
                'type' => 4,
                'flow' => 1,
                'generated_by' => $User->id,
                'status' => 1,
            ]);
        }

        if($memberTree && $memberTree->sponsor_id && $level < 10) {
            $level  = $level + 1;
            $this->generationIncome($returnAmount, $memberTree->sponsor_id, $User, $level);
        }
    }
}