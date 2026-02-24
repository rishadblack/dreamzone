<?php
namespace App\Traits;

use App\Models\Income;
use App\Models\MemberTree;
use App\Models\Point;
use App\Models\User;
use Illuminate\Support\Facades\App;

trait MemberUpgradeTrait
{
    public $package_id;
    public $is_coupon;
    public $coupon_code;
    public $note;
    public $to_note;
    public $trams_checked;
    public $sponsor_username;
    public $placement_username;
    public $placement_team;
    public $set_txn_pin;
    public $txn_pin;
    public $is_upgraded;

    public function updatedPlacementTeam($value)
    {
        $this->resetValidation('placement_team');

        if (! $this->sponsor_username) {
            $this->addError('sponsor_username', 'Please select sponsor username then try again');
            $this->reset('placement_team');

            return true;
        } elseif (! $this->placement_username) {
            $this->addError('placement_username', 'Please select placement username then try again');
            $this->reset('placement_team');

            return true;
        }

        $placement = User::where('username', $this->placement_username)->first();

        if ($value == 1 && $placement->memberTree->l_id) {
            $this->addError('placement_team', $this->placement_username . '  is already have a team member on Team A');

            return true;
        } elseif ($value == 2 && $placement->memberTree->r_id) {
            $this->addError('placement_team', $this->placement_username . '  is already have a team member on Team A');

            return true;
        }
    }

    public function checkPlacement($attribute, $value, $fail)
    {
        $placement = User::where('username', $this->placement_username)->first();

        if ($placement && $attribute == 'placement_team') {
            if (! $placement->memberTree->l_id && $value == 1) {
                return true;
            } elseif (! $placement->memberTree->r_id && $value == 2) {
                return true;
            } else {
                $fail('Team is not available.');
            }
        }
    }

    public function memberUpgrade($user_id)
    {

        $User = User::sumPoint()->find($user_id);

        if (! $User) {
            return true;
        }

        if ($User->id !== 1) {
            if ($User->available_point <= 0) {
                return true;
            }

            if (! $User->memberTree->sponsor_id) {
                return true;
            }

            if (! $User->memberTree->placement_id) {
                return true;
            }
        }

        $PointUpgrade = new Point;
        $PointUpgrade->user_id = $User->id;
        $PointUpgrade->parent_id = $User->id;
        $PointUpgrade->value = $User->available_point;
        $PointUpgrade->type = 2;
        $PointUpgrade->flow = 2;
        $PointUpgrade->generated_by = $User->id;
        $PointUpgrade->status = 1;
        $PointUpgrade->save();

        $sponsorBonusAmount = $PointUpgrade->value * config('mlm.income_list.1.percentage') / 100;

        if ($User->memberTree->sponsor_id) {
            Income::create([
                'user_id' => $User->memberTree->sponsor_id,
                'parent_id' => $PointUpgrade->user_id,
                'point_id' => $PointUpgrade->id,
                'order_id' => $PointUpgrade->order_id,
                'amount' => $sponsorBonusAmount,
                'net_amount' => $sponsorBonusAmount,
                'wallet_type' => 1,
                'level' => 1,
                'type' => 1,
                'flow' => 1,
                'generated_by' => $PointUpgrade->user_id,
                'status' => 1,
            ]);
        }

        $totalUpgrade = Point::whereUserId($User->id)->whereType(2)->whereFlow(2)->sum('value');

        if ($totalUpgrade >= config('mlm.premium_point') && ! $User->memberTree->is_premium) {
            $User->memberTree->is_premium = now();
        }

        $User->memberTree->p_point = $totalUpgrade;
        $User->memberTree->save();
    }
}
