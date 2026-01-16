<?php

namespace App\Console\Commands;

use App\Models\Fund;
use App\Models\Income;
use App\Models\Balance;
use App\Models\Package;
use App\Models\MemberTree;
use App\Models\Achievement;
use App\Models\Designation;
use Illuminate\Console\Command;

class MemberStatement extends Command
{
    protected $signature = 'member:statement';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info(json_encode($this->getMember('1')));
    }

    private function getMember($memberId)
    {
        $getCurrentMember = MemberTree::where('member_trees.user_id', $memberId)->first();
        $TotalUpgrade = Fund::whereUserId($getCurrentMember->user_id)->whereNotNull('is_attached')->whereNull('is_detached_request')->whereStatus(1)->sum('attached_amount');

        $Package =   Package::where('amount', '<=', $TotalUpgrade)->active()->orderBy('amount', 'desc')->first();

        $getCurrentMember->package_id = $Package ? $Package->id : null;

        $getMembers = MemberTree::wherePlacementId($getCurrentMember->user_id)->get();

        $placementMember['total_member'] = 0;
        $placementMember['total_member_count'][$memberId] = 0;

        $placementMember['total_premium'] = 0;
        $placementMember['total_premium_count'][$memberId] = 0;

        $placementMember['total_value'] = 0;
        $placementMember['total_value_count'][$memberId] = $TotalUpgrade;

        foreach (config('mlm.incentives') as $key => $value) {
            $placementMember['total_plan'][$key] = 0;
            $totalPlan[$memberId][$key] = 0;
        }

        foreach ($getMembers as $getMember) {
            $getplacementMember = $this->getMember($getMember['user_id']);
            $placementMember['total_member_count'][$memberId] += $getplacementMember['total_member'] + 1;
            $placementMember['total_value_count'][$memberId] += $getplacementMember['total_value'];
            if($getMember->is_premium) {
                $placementMember['total_premium_count'][$memberId] += $getplacementMember['total_premium'] + 1;
            }


            foreach (config('mlm.incentives') as $key => $value) {
                if ($getplacementMember['incentive_id'] == $key) {
                    $totalPlan[$memberId][$key] += $getplacementMember['total_plan'][$key] + 1;

                } else {
                    $totalPlan[$memberId][$key] += $getplacementMember['total_plan'][$key];
                }
            }
        }

        $placementMember['incentive_id'] = $getCurrentMember->incentive_id;
        $placementMember['total_member'] = $placementMember['total_member_count'][$memberId];
        $placementMember['total_value'] = $placementMember['total_value_count'][$memberId];
        $placementMember['total_premium'] = $placementMember['total_premium_count'][$memberId];

        foreach (config('mlm.incentives') as $key => $value) {
            $placementMember['total_plan'][$key] = $totalPlan[$memberId][$key];
        }

        //Member
        $getCurrentMember->total_member = $placementMember['total_member'] > 0 ? $placementMember['total_member'] : 0;

        //Premium Member
        $getCurrentMember->total_premium = $placementMember['total_premium'] > 0 ? $placementMember['total_premium'] : 0;
        //Point
        $getCurrentMember->total_point = $placementMember['total_value'] > 0 ? $placementMember['total_value'] : 0;

        //Personal Point
        $getCurrentMember->p_point = $TotalUpgrade > 0 ? $TotalUpgrade : 0;
        $getCurrentMember->details = $placementMember;
        $getCurrentMember->save();


        //Designation Upgrade
        // if (config('mlm.incentives.1.condition_amount') <= $getCurrentMember->total_point) {
        //     $TotalSponsor = MemberTree::whereSponsorId($getCurrentMember->user_id)->whereNotNull('is_premium')->where('p_point', '>', 0)->count();
        //     foreach (config('mlm.incentives') as $key => $value) {
        //         $incentiveId = $key - 1;

        //         if ($incentiveId < 0) {
        //             $incentiveId = null;
        //         }

        //         //Self Attachment
        //         if ($value['self_attached'] > $TotalUpgrade) {
        //             continue;
        //         }

        //         //Sponsor Condition
        //         if($value['sponsor_condition'] > $TotalSponsor) {
        //             continue;
        //         }

        //         //Condition Amount
        //         if ($value['condition_amount'] > $getCurrentMember->total_point) {
        //             continue;
        //         }

        //         //Achievement Count
        //         if ($incentiveId && $value['condition_count'] > $placementMember['total_plan'][$incentiveId]) {
        //             continue;
        //         }

        //         //One Placement Max Condition
        //         if ($value['capping'] > 0) {
        //             if (!MemberTree::wherePlacementId($getCurrentMember->user_id)->where('total_point', '>=', $value['capping'])->exists()) {
        //                 continue;
        //             }
        //         }


        //         if ($getCurrentMember->incentive_id == $incentiveId) {
        //             $getCurrentMember->incentive_id = $key;
        //             $getCurrentMember->incentive_start = now();
        //             $getCurrentMember->save();

        //             $Achievement = new Achievement();
        //             $Achievement->user_id = $getCurrentMember->user_id;
        //             $Achievement->incentive_id = $key;
        //             $Achievement->status = 1;
        //             $Achievement->save();
        //         }
        //     }
        // }

        $this->info('Member ' . $getCurrentMember->user_id . ' has been updated.');

        return $placementMember;
    }

    private function getRatioCheck($lMember, $rMember, $lCondition, $rCondition)
    {
        $totalMember = $lMember + $rMember;
        $totalCondition = $lCondition + $rCondition;
        if ($totalCondition <= $totalMember) {
            if ($lMember > $rMember) {
                if ($lMember >= $lCondition && $rMember >= $rCondition) {
                    return true;
                }
            } else {
                if ($rMember >= $lCondition && $lMember >= $rCondition) {
                    return true;
                }
            }
        }

        return false;
    }
}
