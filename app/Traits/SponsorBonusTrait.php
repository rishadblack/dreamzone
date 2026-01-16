<?php

namespace App\Traits;

use App\Models\Point;
use App\Models\Income;
use App\Models\MemberTree;

trait SponsorBonusTrait
{
    public function sendSponsorBonus(int $senderId, float $totalPoint, string $note = null, int $pointId = null)
    {
        $SenderMemberTree = MemberTree::whereUserId($senderId)->first();
        $ReceivedMemberTree = MemberTree::whereUserId($SenderMemberTree->sponsor_id)->first();

        $sponsorBonusAmount = 0;
        if($ReceivedMemberTree->p_point >= 500) {
            $sponsorBonusAmount = $totalPoint * config('mlm.income_list.1.percentage.3') / 100;
        } elseif($ReceivedMemberTree->p_point >= 100) {
            $sponsorBonusAmount = $totalPoint * config('mlm.income_list.1.percentage.2') / 100;
        } elseif($ReceivedMemberTree->p_point >= 25) {
            $sponsorBonusAmount = $totalPoint * config('mlm.income_list.1.percentage.1') / 100;
        }

        if($sponsorBonusAmount <= 0) {
            return;
        }

        Income::create([
            'user_id' => $SenderMemberTree->sponsor_id,
            'parent_id' => $SenderMemberTree->user_id,
            'point_id' => $pointId,
            'amount' => $sponsorBonusAmount,
            'net_amount' => $sponsorBonusAmount,
            'wallet_type' => 1,
            'level' => null,
            'type' => 1,
            'flow' => 1,
            'generated_by' => $SenderMemberTree->user_id,
            'status' => 1,
        ]);

    }


}
