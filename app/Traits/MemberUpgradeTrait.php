<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Point;
use App\Models\Income;
use App\Models\Package;
use App\Jobs\ProcessSms;
use App\Models\MemberTree;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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

    protected $listeners = [
        'openUpgradeModal',
    ];

    public function updatedPlacementTeam($value)
    {
        $this->resetValidation('placement_team');

        if (!$this->sponsor_username) {
            $this->addError('sponsor_username', 'Please select sponsor username then try again');
            $this->reset('placement_team');

            return true;
        } elseif (!$this->placement_username) {
            $this->addError('placement_username', 'Please select placement username then try again');
            $this->reset('placement_team');

            return true;
        }

        $placement = User::where('username', $this->placement_username)->first();

        if ($value == 1 && $placement->memberTree->l_id) {
            $this->addError('placement_team', $this->placement_username.'  is already have a team member on Team A');

            return true;
        } elseif ($value == 2 && $placement->memberTree->r_id) {
            $this->addError('placement_team', $this->placement_username.'  is already have a team member on Team A');

            return true;
        }
    }

    public function checkPlacement($attribute, $value, $fail)
    {
        $placement = User::where('username', $this->placement_username)->first();

        if ($placement && $attribute == 'placement_team') {
            if (!$placement->memberTree->l_id && $value == 1) {
                return true;
            } elseif (!$placement->memberTree->r_id && $value == 2) {
                return true;
            } else {
                $fail('Team is not available.');
            }
        }
    }

    public function memberUpgrade()
    {
        $this->resetValidation();

        $sponsor = User::where('username', $this->sponsor_username)->first();
        $placement = User::where('username', $this->placement_username)->first();
        $User = User::sumPoint()->find(Auth::id());
        $MemberTree = MemberTree::where('user_id', Auth::id())->first();
        $CouponUser = null;

        $getValidation = [];

        if ($this->is_coupon) {
            $getValidation = array_merge($getValidation, ['coupon_code' => ['required', 'exists:users,coupon_code']]);
        } else {
            $getValidation = array_merge($getValidation, ['package_id' => ['required', 'exists:packages,id']]);
        }

        if ($this->is_upgraded) {
            $getValidation = array_merge($getValidation, ['txn_pin' => ['required', 'min:4', 'max:8', 'exists:users,pin,id,'.$User->id]]);
        } else {
            $getValidation = array_merge($getValidation, [
                'sponsor_username' => ['required', 'min:4', 'max:50', 'alpha_dash', 'exists:users,username'],
                'placement_username' => ['required', 'min:4', 'max:50', 'alpha_dash', 'exists:users,username'],
                'placement_team' => ['required',
                    function ($attribute, $value, $fail) {
                        $this->checkPlacement($attribute, $value, $fail);
                    },
                ],
                'set_txn_pin' => ['required', 'min:4', 'max:8'],
            ]);
        }

        $this->validate($getValidation);

        if ($this->is_coupon) {
            $CouponUser = User::whereCouponCode($this->coupon_code)->where('coupon_remaining', '>', 0)->first();

            if (!$CouponUser) {
                $this->addError('coupon_code', 'Coupon code is not valid.');

                return true;
            }
        }

        $Package = Package::find($this->is_coupon && $CouponUser ? $CouponUser->coupon_package_id : $this->package_id);

        if ($Package->amount > $User->available_point) {
            $this->alert('error', 'You do not have enough pv to upgrade.');

            return true;
        }

        if ($placement->id == $User->id) {
            $this->alert('error', 'Current Username and Placement Username is same please check');

            return true;
        }

        if (!$placement->memberTree->sponsor_id && $placement->id != 1) {
            $this->alert('error', 'Selected Placement Member is not upgraded yet.');

            return true;
        }

        if ($sponsor->id == $User->id) {
            $this->alert('error', 'Current Username and Sponsor Username is same please check');

            return true;
        }

        if (!$sponsor->memberTree->sponsor_id && $sponsor->id != 1) {
            $this->alert('error', 'Selected Sponsor Member is not upgraded yet.');

            return true;
        }

        if ($MemberTree->sponsor_id) {
            $this->alert('error', 'You are already upgraded.');

            return true;
        }

        try {
            DB::beginTransaction();

            $MemberTree->package_id = $Package->id;
            $MemberTree->p_point = $MemberTree->p_point + $Package->amount;

            if (!$this->is_upgraded) {
                $MemberTree->sponsor_id = $sponsor->id;
                $MemberTree->placement_id = $placement->id;
            }

            $MemberTree->save();

            if (!$this->is_upgraded) {
                if ($this->placement_team == 1) {
                    $placement->memberTree->l_id = $User->id;
                } else {
                    $placement->memberTree->r_id = $User->id;
                }
                $placement->memberTree->save();
                $User->pin = $this->set_txn_pin;
            }

            $User->register_by = $this->is_coupon ? $CouponUser->id : $User->id;
            $User->register_by = $User->id;
            $User->save();

            $User->assignRole('user');

            if ($Package->amount > 0) {
                $Point = new Point();
                $Point->user_id = $User->id;
                $Point->parent_id = $User->id;
                $Point->package_id = $Package->id;
                $Point->coupon_code = $this->coupon_code ? $this->coupon_code : null;
                $Point->value = $Package->amount;
                $Point->type = 2;
                $Point->flow = 2;
                $Point->generated_by = $User->id;
                $Point->status = 1;
                $Point->save();

                $sponsorBonusAmount = $Package->amount * config('mlm.income_list.1.percentage') / 100;

                Income::create([
                    'user_id' => $User->memberTree->sponsor_id,
                    'parent_id' => $User->id,
                    'point_id' => $Point->id,
                    'order_id' => $Point->order_id,
                    'amount' => $sponsorBonusAmount,
                    'net_amount' => $sponsorBonusAmount,
                    'level' => 1,
                    'type' => 1,
                    'flow' => 1,
                    'generated_by' => $User->id,
                    'status' => 1,
                ]);

                $totalUpgrade = Point::whereUserId($User->id)->whereType(2)->whereFlow(2)->sum('value');

                if ($totalUpgrade >= config('mlm.premium_point')) {
                    $User->memberTree->is_premium = now();
                }

                $User->memberTree->p_point = $totalUpgrade;
                $User->memberTree->save();

                //Super Founder Commission
                $superFounders = MemberTree::whereNotNull('is_super_founder')->get();

                $superFounderBonusAmount = $Package->amount * config('mlm.income_list.4.percentage') / 100;

                if ($superFounders->count() > 0) {
                    $superFounderBonusAmount = $superFounderBonusAmount / $superFounders->count();

                    foreach ($superFounders as $key => $superFounder) {
                        Income::create([
                            'user_id' => $superFounder->user_id,
                            'parent_id' => $User->id,
                            'point_id' => $Point->id,
                            'order_id' => $Point->order_id,
                            'amount' => $superFounderBonusAmount,
                            'net_amount' => $superFounderBonusAmount,
                            'type' => 4,
                            'flow' => 1,
                            'generated_by' => $User->id,
                            'status' => 1,
                        ]);
                    }
                }
            }

            if ($this->is_coupon) {
                $CouponUser->coupon_remaining = $CouponUser->coupon_remaining - 1;
                $CouponUser->coupon_use = $CouponUser->coupon_use + 1;
                $CouponUser->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $this->alert('success', 'System Error. Please contact Administrator.');

            return true;
        }

        $this->dispatchBrowserEvent('modalClose', 'UpgradeModal');

        if (Auth::User()->mobile && App::environment('production')) {
            ProcessSms::dispatch([Auth::User()->mobile], 'Congratulation! Your account now upgraded. Thanks '.config('app.name'), 'Upgrade');
        }

        $this->reset();

        $this->alert('success', 'You have successfully upgraded your account.');
    }
}
