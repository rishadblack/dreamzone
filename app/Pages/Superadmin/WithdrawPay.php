<?php

namespace App\Pages\Superadmin;

use App\Models\User;
use App\Http\Common\Component;
use App\Models\Withdrawal;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class WithdrawPay extends Component
{
    use LivewireAlert;

    public $withdrawal_id;
    public $type = 2;
    public $payment_method_id;
    public $account_no;
    public $account_details;
    public $amount;
    public $charge = 0;
    public $net_amount;
    public $note;
    public $name;
    public $username;
    public $phone;
    public $status;

    #[On('openWithdrawalPayModal')]
    public function openWithdrawalPayModal($data)
    {
        $this->dispatch('modalOpen', 'WithdrawalPayModal');
        $this->reset();
        if (isset($data['id'])) {
            $withdrawal = Withdrawal::find($data['id']);
            $this->withdrawal_id = $withdrawal->id;
            $this->type = $withdrawal->type;
            $this->payment_method_id = $withdrawal->payment_method_id;
            $this->account_no = $withdrawal->account_no;
            $this->account_details = $withdrawal->account_details;
            $this->amount = $withdrawal->amount;
            $this->charge = $withdrawal->charge;
            $this->net_amount = $withdrawal->net_amount;
            $this->note = $withdrawal->note;
            $this->name = $withdrawal->User->name;
            $this->username = $withdrawal->User->username;
            $this->phone = $withdrawal->User->phone;
            $this->status = $withdrawal->status;
        }
    }

    public function updatedAmount($value)
    {
        $this->charge = $value * config('mlm.withdraw_charge') / 100;
        $this->net_amount = $value;
    }

    public function storeWithdrawal()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method_id' => 'required',
        ]);

        $Withdrawal = Withdrawal::find($this->withdrawal_id);
        $Withdrawal->type = $this->type;
        $Withdrawal->amount = $this->amount;
        $Withdrawal->charge = $this->charge;
        $Withdrawal->net_amount = $this->net_amount;
        $Withdrawal->payment_method_id = $this->payment_method_id;
        $Withdrawal->account_no = $this->account_no;
        $Withdrawal->account_details = $this->account_details;
        $Withdrawal->status = $this->status;
        $Withdrawal->note = $this->note;
        $Withdrawal->save();

        $Withdrawal->Income->amount = $Withdrawal->amount;
        $Withdrawal->Income->net_amount = $Withdrawal->amount;
        if ($this->status == 3) {
            $Withdrawal->Income->status = $this->status;
        } else {
            $Withdrawal->Income->status = 1;
        }
        $Withdrawal->Income->save();

        $this->dispatch('modalClose', 'WithdrawalPayModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Withdrawal updated successfully');
        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.withdraw-pay', [
            'user' => Auth::user(),
        ]);
    }
}
