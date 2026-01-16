<?php

namespace App\Pages\Backend;

use App\Models\Fund;
use App\Models\User;
use App\Models\Point;
use App\Models\Income;
use App\Models\Package;
use App\Http\Common\Component;
use App\Models\MemberTree;
use App\Models\Achievement;
use Livewire\Attributes\On;
use App\Traits\SponsorBonusTrait;
use Illuminate\Support\Facades\DB;
use App\Traits\UsernameSearchTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UpgradeList extends Component
{
    use UsernameSearchTrait;
    use LivewireAlert;
    use SponsorBonusTrait;

    public $is_self_upgrade = true;
    public $username;
    public $package_id;
    public $value;
    public $note;
    public $to_note;
    public $is_agree;

    public function updatedPackageId($value)
    {
        if(!empty($value)) {
            $this->value = Package::find($value)->amount;
        } else {
            $this->value = null;
        }
    }

    public function storeActivation()
    {
        $Validation = [
            'value' => 'required|numeric',
            'is_agree' => 'required',
        ];

        if(!$this->is_self_upgrade) {
            $Validation = array_merge($Validation, [
                'username' => 'required|exists:users,username',
            ]);
        }

        $this->validate($Validation);

        $transferUser = User::whereUsername($this->username)->first();
        $User = Auth::User();

        if (!$this->is_self_upgrade && $transferUser->id == $User->id) {
            $this->addError('username', 'You can not transfer to yourself');
            return true;
        }

        $availablePoint = Point::availablePoint()->whereUserId($User->id)->whereStatus(1)->first()->available_point;

        if ($availablePoint < 0) {
            $this->addError('value', 'You have not enough fund to attach');

            return true;
        }

        if ($this->value > $availablePoint) {
            $this->addError('value', 'You have not enough fund to attach');

            return true;
        }

        if ($User->is_banned) {
            $this->alert('error', 'Your account is banned');

            return true;
        }

        if(!$this->is_self_upgrade) {
            if(!$transferUser->memberTree->is_premium) {
                $this->alert('error', 'Active remote user account first');

                return true;
            }
        }

        if(!$User->memberTree->is_premium) {
            $this->alert('error', 'Active your account first');

            return true;
        }

        try {
            DB::beginTransaction();

            if(!$this->is_self_upgrade) {
                $fromPoint = new Point();
                $fromPoint->user_id = $User->id;
                $fromPoint->parent_id = $transferUser->id;
                $fromPoint->value = $this->value;
                $fromPoint->type = 3;
                $fromPoint->flow = 2;
                $fromPoint->generated_by = $User->id;
                $fromPoint->status = 1;
                $fromPoint->note = $this->note;
                $fromPoint->save();

                $toPoint = new Point();
                $toPoint->user_id = $transferUser->id;
                $toPoint->parent_id = $User->id;
                $toPoint->value = $this->value;
                $toPoint->type = 3;
                $toPoint->flow = 1;
                $toPoint->generated_by = $User->id;
                $toPoint->status = 1;
                $toPoint->note = $this->to_note;
                $toPoint->save();
            }

            $upgradePoint = new Point();
            $upgradePoint->user_id = $this->is_self_upgrade ? $User->id : $transferUser->id;
            $upgradePoint->parent_id = $User->id;
            $upgradePoint->value = $this->value;
            $upgradePoint->type = 2;
            $upgradePoint->flow = 2;
            $upgradePoint->generated_by = $User->id;
            $upgradePoint->status = 1;
            $upgradePoint->note = $this->note;
            $upgradePoint->save();

            $MemberTree = MemberTree::where('user_id', $upgradePoint->user_id)->first();
            $MemberTree->is_premium = $MemberTree->is_premium ?? now();
            $MemberTree->p_point = Point::upgradePoint()->whereUserId($upgradePoint->user_id)->whereStatus(1)->first()->upgrade_point;

            $Package =   Package::where('amount', '<=', $MemberTree->p_point)->active()->orderBy('amount', 'desc')->first();
            $MemberTree->package_id = $Package ? $Package->id : null;
            $MemberTree->save();

            if($MemberTree->sponsor_id) {
                $this->sendSponsorBonus($MemberTree->user_id, $upgradePoint->value, $this->note, $upgradePoint->id);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $this->alert('error', 'System Error. Please contact Administrator.');

            return true;
        }

        $this->dispatch('modalClose', 'TransferModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Fund attached successfully.');
        $this->reset();
    }

    public function render()
    {
        return view('pages.backend.upgrade-list', [
            'available_point' => Point::availablePoint()->whereUserId(Auth::id())->whereStatus(1)->first()->available_point,
        ]);
    }
}
