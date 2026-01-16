<?php

namespace App\Pages\Backend;

use App\Models\User;
use App\Models\Income;
use App\Models\Balance;
use App\Http\Common\Component;
use App\Models\Withdrawal;
use Livewire\Attributes\On;
use App\Traits\UsernameSearchTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class WithdrawalList extends Component
{
    use LivewireAlert;
    use UsernameSearchTrait;

    public $type = 2;
    public $payment_method_id;
    public $account_no;
    public $account_details;
    public $amount;
    public $charge = 0;
    public $net_amount;
    public $note;
    public $username;

    #[On('demandForm')]
    public function testEvent($data) {}

    public function updatedType()
    {
        $this->updatedAmount();
    }

    public function updatedAmount()
    {
        if ($this->type != 3 && $this->amount > 0) {
            $this->charge = $this->amount * config('mlm.withdraw_charge') / 100;
            $this->net_amount = $this->amount - $this->charge;
        } else {
            $this->net_amount = $this->amount;
            $this->charge = 0;
        }
    }

    public function storeWithdrawal()
    {

        $getValidation = [
            'amount' => 'required|numeric|min:1',
            'type' => 'required',
        ];

        if ($this->type == 2) {
            $getValidation = array_merge($getValidation, [
                'payment_method_id' => ['required'],
            ]);

            if ($this->payment_method_id != 1) {
                $getValidation = array_merge($getValidation, [
                    'account_no' => ['required'],
                ]);
            }
        }

        if ($this->type == 3) {
            $getValidation = array_merge($getValidation, [
                'username' => 'required|exists:users,username',
            ]);
        }

        $this->validate($getValidation);

        $User = User::find(Auth::id());

        $availableIncome = Income::availableIncome()
                            ->whereUserId($User->id)
                            ->whereWalletType(1)
                            ->whereStatus(1)
                            ->first()->available_income;

        if ($availableIncome < 0) {
            $this->addError('amount', 'You have not enough balance to withdraw');

            return true;
        }

        if ($this->amount > $availableIncome) {
            $this->addError('amount', 'You have not enough account balance to withdraw');

            return true;
        }

        if ($this->amount < config('mlm.minumum_withdraw')) {
            $this->addError('amount', 'Minimum ' . numberFormat(config('mlm.minumum_withdraw'), true) . ' is required to withdraw');

            return true;
        }

        if (!$User->is_approve) {
            $this->alert('error', 'Your account is not approved yet');

            return true;
        }

        if (!$User->memberTree->is_premium) {
            $this->alert('error', 'Upgrade your account first');

            return true;
        }

        if ($User->is_banned) {
            $this->alert('error', 'Your account is banned');

            return true;
        }

        if ($User->is_not_withdrawalable) {
            $this->alert('error', 'Your account withdrawal is blocked');

            return true;
        }

        if (setting('access_withdrawal') == 'N') {
            $this->alert('error', 'Withdrawal is not allowed at this moment please try again later');
            return true;
        }


        $withdrawalCharge = $this->amount * config('mlm.withdraw_charge') / 100;

        $Withdrawal = new Withdrawal();
        $Withdrawal->user_id = Auth::id();
        $Withdrawal->type = $this->type;
        $Withdrawal->amount = $this->amount;
        $Withdrawal->wallet_type = 1;
        $Withdrawal->charge = $Withdrawal->type != 3 ? $withdrawalCharge : 0;
        $Withdrawal->net_amount = $Withdrawal->type != 3 ? ($Withdrawal->amount - $Withdrawal->charge) : $Withdrawal->amount;
        $Withdrawal->payment_method_id = $this->payment_method_id;
        $Withdrawal->account_no = $this->account_no;
        $Withdrawal->account_details = $this->account_details;
        $Withdrawal->status = $Withdrawal->type == 2 ? 2 : 1;
        $Withdrawal->note = $this->note;
        $Withdrawal->save();

        $Income = Income::create([
            'user_id' => Auth::id(),
            'parent_id' => $Withdrawal->type == 3 ? $this->getIdByUsername($this->username) : Auth::id(),
            'withdrawal_id' => $Withdrawal->id,
            'amount' => $Withdrawal->amount,
            'net_amount' => $Withdrawal->amount,
            'wallet_type' => 1,
            'type' => $Withdrawal->type == 3 ? 9 : 7,
            'flow' => 2,
            'generated_by' => Auth::id(),
            'status' => 1,
        ]);

        if ($Withdrawal->type == 1) {
            $Balance = new Balance();
            $Balance->user_id = Auth::id();
            $Balance->parent_id = Auth::id();
            $Balance->income_id = $Income->id;
            $Balance->withdrawal_id = $Withdrawal->id;
            $Balance->amount = $Withdrawal->net_amount;
            $Balance->net_amount = $Withdrawal->net_amount;
            $Balance->wallet_type = 1;
            $Balance->type = 5;
            $Balance->flow = 1;
            $Balance->generated_by = Auth::id();
            $Balance->status = 1;
            $Balance->note = $this->note;
            $Balance->save();
        } elseif ($Withdrawal->type == 3) {
            Income::create([
                'user_id' => $this->getIdByUsername($this->username),
                'parent_id' => Auth::id(),
                'withdrawal_id' => $Withdrawal->id,
                'amount' => $Withdrawal->amount,
                'net_amount' => $Withdrawal->amount,
                'wallet_type' => 1,
                'type' => 9,
                'flow' => 1,
                'generated_by' => Auth::id(),
                'status' => 1,
            ]);
        }

        $this->dispatch('modalClose', 'WithdrawalModal');
        $this->dispatch('refreshdatatable');
        $this->alert('success', 'Your withdrawal request has been sent successfully');
        $this->reset();
    }

    public function render()
    {
        $User = Auth::user();
        $availableIncome = Income::availableIncome()
                                ->whereUserId($User->id)
                                ->whereWalletType(1)
                                ->whereStatus(1)
                                ->first();
        return view('pages.backend.withdrawal-list', [
            'user' => $User,
            'available_income' => $availableIncome,
        ]);
    }
}
