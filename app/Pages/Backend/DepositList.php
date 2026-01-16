<?php

namespace App\Pages\Backend;

use App\Models\Deposit;
use App\Http\Common\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepositList extends Component
{
    use LivewireAlert;

    public $type = 2;
    public $payment_method_id;
    public $account_no;
    public $account_details;
    public $amount;
    public $charge = 0;
    public $net_amount;
    public $note;
    public $to_account;

    public function updatedAmount($value)
    {
        $this->net_amount = $value;
    }

    public function updatedPaymentMethodId($value)
    {
        if($value) {
            $this->to_account = config('status.payment_method.' . $value . '.account_no');
        }
    }

    public function storeDeposit()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method_id' => 'required',
        ]);

        if ($this->amount < config('mlm.minumum_deposit')) {
            $this->addError('amount', 'Minimum ' . numberFormat(config('mlm.minumum_deposit'), true) . ' is required to deposit');

            return true;
        }

        $Deposit = new Deposit();
        $Deposit->user_id = Auth::id();
        $Deposit->type = $this->type;
        $Deposit->amount = $this->amount;
        $Deposit->charge = $this->charge;
        $Deposit->net_amount = $this->net_amount;
        $Deposit->payment_method_id = $this->payment_method_id;
        $Deposit->account_no = $this->account_no;
        $Deposit->account_details = $this->account_details;
        $Deposit->status = 2;
        $Deposit->note = $this->note;
        $Deposit->save();

        $this->dispatch('modalClose', 'DepositModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Your deposit request has been received successfully');
        $this->reset();
    }

    public function render()
    {
        return view('pages.backend.deposit-list');
    }
}
