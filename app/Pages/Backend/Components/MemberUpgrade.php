<?php
namespace App\Pages\Backend\Components;

use App\Http\Common\Component;
use App\Models\MemberTree;
use App\Models\Package;
use App\Models\Point;
use App\Models\User;
use App\Traits\MemberUpgradeTrait;
use App\Traits\UsernameSearchTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberUpgrade extends Component
{
    use UsernameSearchTrait;
    use MemberUpgradeTrait;

    public $is_free;
    public $placement_id;
    public $placement_team;
    public $username;
    public $value;
    public $available_point;
    public $is_sponsor;
    public $sponsor_username;

    protected $listeners = [
        'openMemberUpgradeModal',
    ];

    public function openMemberUpgradeModal($data = [])
    {
        $this->resetErrorBag();
        $this->reset();

        if (isset($data['placement_id'])) {
            $this->placement_id = $data['placement_id'];
            $this->placement_team = $data['placement_team'];
        }
        $this->dispatch('modalOpen', 'MemberUpgradeModal');
    }

    public function updated($key, $value)
    {
        $this->resetErrorBag();

        if ($key == 'username') {
            $user = User::where('username', $value)->first();

            if ($user) {
                $this->available_point = Point::availablePoint()->whereUserId($user->id)->whereStatus(1)->first()->available_point;
                $this->is_sponsor = MemberTree::whereUserId($user->id)->whereNotNull('sponsor_id')->exists();
            } else {
                $this->available_point = 0;
                $this->is_sponsor = null;
            }

        }

    }

    public function storeActivation()
    {
        $Validation = [
            'username' => 'required|exists:users,username',
        ];

        if (! $this->is_free) {
            $Validation = array_merge($Validation, [
                'value' => 'required|numeric',
            ]);
        }

        if (! $this->is_sponsor) {
            $Validation = array_merge($Validation, [
                'sponsor_username' => 'required|exists:users,username',
            ]);
        }

        $this->validate($Validation);

        $upgradeUser = User::whereUsername($this->username)->first();
        $sponsorUser = User::whereUsername($this->sponsor_username)->first();
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

        if (! $this->is_sponsor) {
            if ($sponsorUser->id == $upgradeUser->id) {
                $this->addError('sponsor_username', 'Sponsor can not be same as upgrade user');
                return true;
            }
        }

        $availablePoint = Point::availablePoint()->whereUserId($upgradeUser->id)->whereStatus(1)->first()->available_point;

        if ($this->is_free) {
            if ($User->id !== 1 && $User->free_upgrade <= 0) {
                $this->addError('is_free', 'You have not access special upgrade');
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

        if ($upgradeUser->memberTree->is_premium) {
            $this->alert('error', 'Member already activated');

            return true;
        }

        if (! $placementUser->memberTree->is_premium) {
            $this->alert('error', 'Placement user is not upgrade yet');

            return true;
        }

        if (! $User->memberTree->is_premium) {
            $this->alert('error', 'You are not upgrade yet');

            return true;
        }

        try {
            DB::beginTransaction();
            if ($this->is_free) {
                $User->free_upgrade = $User->id !== 1 ? $User->free_upgrade - 1 : $User->free_upgrade;
                $User->save();
            }

            $PlacementMemberTree = MemberTree::where('user_id', $placementUser->id)->first();
            if (! $PlacementMemberTree->l_id && $this->placement_team == 'a') {
                $PlacementMemberTree->l_id = $upgradeUser->id;
            } elseif (! $PlacementMemberTree->r_id) {
                $PlacementMemberTree->r_id = $upgradeUser->id;
            }
            $PlacementMemberTree->save();

            $MemberTree = MemberTree::where('user_id', $upgradeUser->id)->first();
            $MemberTree->p_point = Point::upgradePoint()->whereUserId($upgradeUser->id)->whereStatus(1)->first()->upgrade_point;
            $Package = Package::where('point_value', '<=', $MemberTree->p_point)->active()->orderBy('point_value', 'desc')->first();

            $MemberTree->is_premium = $MemberTree->is_premium ?? now();
            $MemberTree->sponsor_id = $this->is_sponsor ? $MemberTree->sponsor_id : $sponsorUser->id;
            $MemberTree->package_id = $Package ? $Package->id : null;
            $MemberTree->placement_id = $PlacementMemberTree->user_id;
            $MemberTree->save();

            $this->memberUpgrade($upgradeUser->id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            $this->alert('error', 'System Error. Please contact Administrator.');

            return true;
        }

        $this->dispatch('modalClose', 'MemberUpgradeModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Member activated successfully');
        $this->reset();
    }

    public function render()
    {
        return view('pages.backend.components.member-upgrade');
    }
}