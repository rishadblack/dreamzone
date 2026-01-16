<?php

namespace App\Pages\Backend\Components;

use Exception;
use App\Models\User;
use App\Models\Point;
use App\Models\Package;
use App\Http\Common\Component;
use App\Models\MemberTree;
use Illuminate\Support\Facades\DB;
use App\Traits\UsernameSearchTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MemberUpgrade extends Component
{
    use UsernameSearchTrait;
    use LivewireAlert;

    public $is_free;
    public $placement_id;
    public $placement_team;
    public $username;
    public $value;
    public $available_point;

    protected $listeners = [
        'openMemberUpgradeModal',
    ];

    public function openMemberUpgradeModal($data = [])
    {
        $this->resetErrorBag();
        $this->reset();

        if (isset($data['id'])) {
            $this->placement_id = $data['id'];
            $this->placement_team = $data['team'];
            $this->dispatch('modalOpen', 'MemberUpgradeModal');
        }
    }

    public function updated($key, $value)
    {
        $this->resetErrorBag();

        if($key == 'username') {
            $user = User::where('username', $value)->first();

            if ($user) {
                $this->available_point = Point::availablePoint()->whereUserId($user->id)->whereStatus(1)->first()->available_point;
            }
        }

    }

    public function storeActivation()
    {
        $Validation = [
            'username' => 'required|exists:users,username',
        ];
        if(!$this->is_free) {
            $Validation = array_merge($Validation, [
                'value' => 'required|numeric',
            ]);
        }

        $this->validate($Validation);

        $upgradeUser = User::whereUsername($this->username)->first();
        $placementUser = User::find($this->placement_id);
        $User = Auth::user();

        if ($upgradeUser->id == $User->id) {
            $this->addError('username', 'You can not upgrade to yourself');
            return true;
        }

        if ($upgradeUser->id == $placementUser->id) {
            $this->addError('username', 'You can not upgrade to placement user same as upgrade user');
            return true;
        }

        $availablePoint = Point::availablePoint()->whereUserId($upgradeUser->id)->whereStatus(1)->first()->available_point;

        if($this->is_free) {
            if($User->free_upgrade <= 0) {
                $this->addError('value', 'You have not access special upgrade');
                return true;
            }
        } else {
            if ($availablePoint < 0) {
                $this->addError('value', 'You have not enough point to upgrade');

                return true;
            }

            if ($this->value > $availablePoint) {
                $this->addError('value', 'You have not enough point to upgrade');

                return true;
            }
        }


        if ($User->is_banned) {
            $this->alert('error', 'Your account is banned');

            return true;
        }

        if($upgradeUser->memberTree->is_premium) {
            $this->alert('error', 'Member already activated');

            return true;
        }


        if(!$placementUser->memberTree->is_premium) {
            $this->alert('error', 'Placement user is not upgrade yet');

            return true;
        }


        if(!$User->memberTree->is_premium) {
            $this->alert('error', 'You are not upgrade yet');

            return true;
        }

        try {
            DB::beginTransaction();
            if(!$this->is_free) {
                $upgradePoint = new Point();
                $upgradePoint->user_id = $upgradeUser->id;
                $upgradePoint->parent_id = $User->id;
                $upgradePoint->value = $this->value;
                $upgradePoint->type = 2;
                $upgradePoint->flow = 2;
                $upgradePoint->generated_by = $User->id;
                $upgradePoint->status = 1;
                $upgradePoint->save();
            } else {
                $User->free_upgrade = $User->free_upgrade - 1;
                $User->save();
            }

            $PlacementMemberTree = MemberTree::where('user_id', $placementUser->id)->first();
            if(!$PlacementMemberTree->l_id && $this->placement_team == 'a') {
                $PlacementMemberTree->l_id = $upgradeUser->id;
            } elseif(!$PlacementMemberTree->r_id) {
                $PlacementMemberTree->r_id = $upgradeUser->id;
            }
            $PlacementMemberTree->save();


            $MemberTree = MemberTree::where('user_id', $upgradeUser->id)->first();
            $MemberTree->is_premium = $MemberTree->is_premium ?? now();
            $MemberTree->p_point = Point::upgradePoint()->whereUserId($upgradeUser->user_id)->whereStatus(1)->first()->upgrade_point;

            $Package =   Package::where('amount', '<=', $MemberTree->p_point)->active()->orderBy('amount', 'desc')->first();
            $MemberTree->package_id = $Package ? $Package->id : null;
            $MemberTree->placement_id = $PlacementMemberTree->user_id;
            $MemberTree->save();

            if(!$this->is_free && $MemberTree->sponsor_id) {
                $this->sendSponsorBonus($MemberTree->user_id, $upgradePoint->value, $this->note, $upgradePoint->id);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            $this->alert('error', 'System Error. Please contact Administrator.');

            return true;
        }

        $this->dispatch('modalClose', 'TransferModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Member activated successfully');
        $this->reset();
    }

    public function render()
    {
        return view('pages.backend.components.member-upgrade');
    }
}
