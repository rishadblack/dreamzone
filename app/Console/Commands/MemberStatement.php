<?php
namespace App\Console\Commands;

use App\Models\Achievement;
use App\Models\Income;
use App\Models\MemberTree;
use App\Models\Point;
use Illuminate\Console\Command;

class MemberStatement extends Command
{
    protected $signature   = 'member:statement';
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
        $getCurrentMember = MemberTree::where('member_trees.user_id', $memberId)->sumUpgradedPoint()->first();

        $getMembers = MemberTree::wherePlacementId($getCurrentMember->user_id)->get();

        $placementMember['total_member'] = 0;
        $placementMember['total_member_l'] = 0;
        $placementMember['total_member_r'] = 0;
        $placementMember['total_member_count'][$memberId] = 0;

        $placementMember['total_value'] = 0;
        $placementMember['total_value_l'] = 0;
        $placementMember['total_value_r'] = 0;
        $placementMember['total_value_count'][$memberId] = $getCurrentMember->upgraded_point;

        foreach (config('mlm.incentives') as $key => $value) {
            $placementMember['total_plan'][$key] = 0;
            $placementMember['total_plan_l'][$key] = 0;
            $placementMember['total_plan_r'][$key] = 0;

            $totalPlan[$memberId][$key] = 0;
            $totalPlanL[$memberId][$key] = 0;
            $totalPlanR[$memberId][$key] = 0;
        }

        foreach ($getMembers as $getMember) {
            $getplacementMember = $this->getMember($getMember['user_id']);
            $placementMember['total_member_count'][$memberId] += $getplacementMember['total_member'] + 1;
            $placementMember['total_value_count'][$memberId] += $getplacementMember['total_value'];

            if ($getCurrentMember->l_id == $getMember->user_id) {
                $placementMember['total_member_l'] += $getplacementMember['total_member'] + 1;
                $placementMember['total_value_l'] += $getplacementMember['total_value'];
            }

            if ($getCurrentMember->r_id == $getMember->user_id) {
                $placementMember['total_member_r'] += $getplacementMember['total_member'] + 1;
                $placementMember['total_value_r'] += $getplacementMember['total_value'];
            }

            foreach (config('mlm.incentives') as $key => $value) {
                if ($getplacementMember['incentive_id'] == $key) {
                    $totalPlan[$memberId][$key] += $getplacementMember['total_plan'][$key] + 1;

                    if ($getCurrentMember->l_id == $getMember->user_id) {
                        $totalPlanL[$memberId][$key] += $getplacementMember['total_plan'][$key] + 1;
                    }

                    if ($getCurrentMember->r_id == $getMember->user_id) {
                        $totalPlanR[$memberId][$key] += $getplacementMember['total_plan'][$key] + 1;
                    }
                } else {
                    $totalPlan[$memberId][$key] += $getplacementMember['total_plan'][$key];

                    if ($getCurrentMember->l_id == $getMember->user_id) {
                        $totalPlanL[$memberId][$key] += $getplacementMember['total_plan'][$key];
                    }

                    if ($getCurrentMember->r_id == $getMember->user_id) {
                        $totalPlanR[$memberId][$key] += $getplacementMember['total_plan'][$key];
                    }
                }
            }
        }

        $placementMember['incentive_id'] = $getCurrentMember->incentive_id;
        $placementMember['total_member'] = $placementMember['total_member_count'][$memberId];
        $placementMember['total_value'] = $placementMember['total_value_count'][$memberId];

        foreach (config('mlm.incentives') as $key => $value) {
            $placementMember['total_plan'][$key] = $totalPlan[$memberId][$key];
            $placementMember['total_plan_l'][$key] = $totalPlanL[$memberId][$key];
            $placementMember['total_plan_r'][$key] = $totalPlanR[$memberId][$key];
        }

        //Member
        $getCurrentMember->total_member = $placementMember['total_member'] > 0 ? $placementMember['total_member'] : 0;
        $getCurrentMember->l_member = $placementMember['total_member_l'] > 0 ? $placementMember['total_member_l'] : 0;
        $getCurrentMember->r_member = $placementMember['total_member_r'] > 0 ? $placementMember['total_member_r'] : 0;

        //Point
        $getCurrentMember->total_point = $placementMember['total_value'] > 0 ? $placementMember['total_value'] : 0;
        $getCurrentMember->l_point = $placementMember['total_value_l'] > 0 ? $placementMember['total_value_l'] : 0;
        $getCurrentMember->r_point = $placementMember['total_value_r'] > 0 ? $placementMember['total_value_r'] : 0;

        //Personal Point
        $getCurrentMember->p_point = $getCurrentMember->upgraded_point > 0 ? $getCurrentMember->upgraded_point : 0;

        //Matching
        if ($getCurrentMember->l_point >= config('mlm.minimum_matching_point_l') && $getCurrentMember->r_point >= config('mlm.minimum_matching_point_r') && $getCurrentMember->last_matching < now()) {
            $totalMachingPoint = 0;
            $flashMatchingPoint = 0;
            $newMachingPoint = 0;
            // Strong Line Select
            if ($getCurrentMember->l_point >= $getCurrentMember->r_point) {
                $totalMachingPoint = $getCurrentMember->r_point;
            } elseif ($getCurrentMember->l_point <= $getCurrentMember->r_point) {
                $totalMachingPoint = $getCurrentMember->l_point;
            }

            // Flashing Condition
            if ($getCurrentMember->total_matching > 0) {
                $newMachingPoint = $totalMachingPoint - $getCurrentMember->total_matching;
            } else {
                $newMachingPoint = $totalMachingPoint;
            }

            $dailyMatching = config('mlm.matching_flash_point');

            if ($newMachingPoint > 0) {
                if ($newMachingPoint >= $dailyMatching) {
                    $flashMatchingPoint = $newMachingPoint - $dailyMatching;
                    $newMachingPoint = $dailyMatching;
                }

                //Matching Bonus
                if ($newMachingPoint > 0) {
                    $matchingBonusAmount = $newMachingPoint * config('mlm.income_list.2.percentage') / 100;
                    if (incomeGenerateCondition($getCurrentMember->user_id)) {
                        Income::create([
                            'user_id' => $getCurrentMember->user_id,
                            'parent_id' => $getCurrentMember->user_id,
                            'amount' => $matchingBonusAmount,
                            'net_amount' => $matchingBonusAmount,
                            'wallet_type' => 1,
                            'flow' => 1,
                            'type' => config('mlm.income_list.2.income_type'),
                            'generated_by' => $getCurrentMember->user_id,
                            'status' => 1,
                            'details' => [
                                'matching_point' => $newMachingPoint,
                                'flash_matching_point' => $flashMatchingPoint,
                            ],
                        ]);
                    }

                    if ($getCurrentMember->sponsor_id) {
                        $this->genarationBonus($getCurrentMember->sponsor_id, $matchingBonusAmount, $getCurrentMember->user_id);
                    }
                }

                $getCurrentMember->paid_matching = $newMachingPoint + $getCurrentMember->paid_matching;
                $getCurrentMember->flash_matching = $flashMatchingPoint + $getCurrentMember->flash_matching;
                $getCurrentMember->total_matching = $totalMachingPoint;
                $getCurrentMember->last_matching = now();
            }
        }

        //Month Matching Income
        if (now()->startOfMonth()->format('d') == now()->format('d')) {
            $getCurrentMember->month_start_point_l = $getCurrentMember->l_point;
            $getCurrentMember->month_start_point_r = $getCurrentMember->r_point;
        }

        $getCurrentMember->details = $placementMember;
        $getCurrentMember->save();

        //Designation Upgrade
        if (config('mlm.incentives.1.condition_l') <= $getCurrentMember->l_point && config('mlm.incentives.1.condition_r') <= $getCurrentMember->r_point) {
            foreach (config('mlm.incentives') as $key => $value) {
                $incentiveId = $key - 1;

                if ($incentiveId < 0) {
                    $incentiveId = null;
                }

                if ($getCurrentMember->incentive_id == $incentiveId && $value['condition_type'] == 'point' && $value['condition_l'] <= $getCurrentMember->l_point && $value['condition_r'] <= $getCurrentMember->r_point) {
                    $getCurrentMember->incentive_id = $key;
                    $getCurrentMember->incentive_start_from = now();
                    $getCurrentMember->save();

                    $Achievement = new Achievement();
                    $Achievement->user_id = $getCurrentMember->user_id;
                    $Achievement->incentive_id = $key;
                    $Achievement->status = 1;
                    $Achievement->save();
                } elseif ($getCurrentMember->incentive_id == $value['condition_type'] && $this->getRatioCheck($placementMember['total_plan_l'][$incentiveId], $placementMember['total_plan_r'][$incentiveId], $value['condition_l'], $value['condition_r'])) {
                    $getCurrentMember->incentive_id = $key;
                    $getCurrentMember->incentive_start_from = now();
                    $getCurrentMember->save();

                    $Achievement = new Achievement();
                    $Achievement->user_id = $getCurrentMember->user_id;
                    $Achievement->incentive_id = $key;
                    $Achievement->status = 1;
                    $Achievement->save();

                }
            }
        }

        //Cashback Condition
        if ($getCurrentMember->is_premium && $getCurrentMember->is_cashback == null) {
            $TotalMonthUpgrade = Point::whereUserId($getCurrentMember->user_id)
                ->whereBetween('created_at', [$getCurrentMember->is_premium, $getCurrentMember->is_premium->addMonths(1)])
                ->whereType(2)
                ->whereFlow(2)
                ->whereStatus(1)
                ->sum('value');

            if ($TotalMonthUpgrade >= config('mlm.premium_point')) {
                $getCurrentMember->is_cashback = now();
                $getCurrentMember->save();
            }
        }

        //Step Condition
        $TotalSponsorPoint = MemberTree::where('user_id', $getCurrentMember->sponsor_id)->sum('p_point');

        // if ($TotalSponsorPoint >= config('mlm.step_point')) {
        //     $getCurrentMember->is_step = now();
        //     $getCurrentMember->save();
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

    private function genarationBonus($userId, $generationBonus, $getCurrentUserId, $level = 1)
    {
        $SponsorMemberTree = MemberTree::where('user_id', $userId)->first();

        if ($SponsorMemberTree) {
            $currentLavel = $level;
            $generationBonusAmount = 0;

            $generationBonusAmount = $generationBonus * config('mlm.generation_list.' . $currentLavel . '.percentage') / 100;

            if ($generationBonusAmount > 0) {
                if (incomeGenerateCondition($SponsorMemberTree->user_id)) {
                    Income::create([
                        'user_id' => $SponsorMemberTree->user_id,
                        'parent_id' => $getCurrentUserId,
                        'amount' => $generationBonusAmount,
                        'net_amount' => $generationBonusAmount,
                        'wallet_type' => 1,
                        'level' => $currentLavel,
                        'flow' => 1,
                        'type' => config('mlm.income_list.3.income_type'),
                        'generated_by' => $getCurrentUserId,
                        'status' => 1,
                    ]);
                }
            }

            $level = $level + 1;

            if ($SponsorMemberTree->sponsor_id && $level < 3) {
                $this->genarationBonus($SponsorMemberTree->sponsor_id, $generationBonus, $getCurrentUserId, $level);
            }
        }
    }
}
