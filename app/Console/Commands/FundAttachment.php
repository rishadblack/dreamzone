<?php

namespace App\Console\Commands;

use App\Models\Fund;
use App\Models\Income;
use App\Models\MemberTree;
use Illuminate\Console\Command;

class FundAttachment extends Command
{
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
        $this->info('Fund attachment command executed');
        $Funds = Fund::whereNotNull('is_attached_request')->whereNull('is_attached')->whereStatus(2)->get();
        foreach ($Funds as $Fund) {
            $Fund->is_attached = now();
            $Fund->attached_amount = $Fund->net_amount;
            $Fund->status = 1;
            $Fund->save();

            $levelOneSponsor = MemberTree::where('user_id', $Fund->user_id)->first();
            $levelOneIncome = $Fund->attached_amount * config('mlm.refer_income_list.1.percentage') / 100;

            if($levelOneSponsor && $levelOneSponsor->sponsor_id && $levelOneIncome > 0) {
                Income::create([
                    'user_id' => $levelOneSponsor->sponsor_id,
                    'parent_id' => $Fund->user_id,
                    'fund_id' => $Fund->id,
                    'amount' => $levelOneIncome,
                    'net_amount' => $levelOneIncome,
                    'level' => 1,
                    'wallet_type' => 1,
                    'type' => 1,
                    'flow' => 1,
                    'generated_by' => $Fund->user_id,
                    'status' => 1,
                ]);



                $levelTwoSponsor = MemberTree::where('user_id', $levelOneSponsor->sponsor_id)->first();
                $levelTwoIncome = $Fund->attached_amount * config('mlm.refer_income_list.2.percentage') / 100;

                if($levelTwoSponsor && $levelTwoSponsor->sponsor_id && $levelTwoIncome > 0) {
                    Income::create([
                        'user_id' => $levelTwoSponsor->sponsor_id,
                        'parent_id' => $Fund->user_id,
                        'fund_id' => $Fund->id,
                        'amount' => $levelTwoIncome,
                        'net_amount' => $levelTwoIncome,
                        'level' => 2,
                        'wallet_type' => 1,
                        'type' => 1,
                        'flow' => 1,
                        'generated_by' => $Fund->user_id,
                        'status' => 1,
                    ]);


                    $levelThreeSponsor = MemberTree::where('user_id', $levelTwoSponsor->sponsor_id)->first();
                    $levelThreeIncome = $Fund->attached_amount * config('mlm.refer_income_list.3.percentage') / 100;

                    if($levelThreeSponsor && $levelThreeSponsor->sponsor_id && $levelThreeIncome > 0) {
                        Income::create([
                            'user_id' => $levelThreeSponsor->sponsor_id,
                            'parent_id' => $Fund->user_id,
                            'fund_id' => $Fund->id,
                            'amount' => $levelThreeIncome,
                            'net_amount' => $levelThreeIncome,
                            'level' => 3,
                            'wallet_type' => 1,
                            'type' => 1,
                            'flow' => 1,
                            'generated_by' => $Fund->user_id,
                            'status' => 1,
                        ]);
                    }

                }
            }

            $MemberTree = MemberTree::where('user_id', $Fund->user_id)->first();
            $MemberTree->is_premium = now();
            $MemberTree->p_point = Fund::where('user_id', $Fund->user_id)->whereNull('is_detached_request')->whereNotNull('is_attached')->where('status', 1)->sum('attached_amount');
            $MemberTree->save();
        }
    }
}
