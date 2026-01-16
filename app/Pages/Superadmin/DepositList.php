<?php

namespace App\Pages\Superadmin;

use App\Models\Balance;
use App\Models\Deposit;
use App\Http\Common\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepositList extends Component
{
    use LivewireAlert;

    public $deposit_id;
    public $type = 2;
    public $payment_method_id;
    public $account_no;
    public $account_details;
    public $amount;
    public $charge = 0;
    public $net_amount;
    public $note;
    public $status;

    protected $listeners = [
        'openDepositModal',
    ];

    #[On('openDepositModal')]
    public function openDepositModal($data)
    {
        $this->dispatch('modalOpen', 'DepositModal');
        $this->reset();

        if (isset($data['id'])) {
            $Deposit = Deposit::find($data['id']);
            $this->deposit_id = $Deposit->id;
            $this->type = $Deposit->type;
            $this->amount = $Deposit->amount;
            $this->charge = $Deposit->charge;
            $this->net_amount = $Deposit->net_amount;
            $this->payment_method_id = $Deposit->payment_method_id;
            $this->account_no = $Deposit->account_no;
            $this->account_details = $Deposit->account_details;
            $this->status = $Deposit->status;
            $this->note = $Deposit->note;

        }
    }

    public function updatedAmount($value)
    {
        $this->net_amount = $value - $this->charge;
    }

    public function updatedCharge($value)
    {
        $this->net_amount = $this->amount - $value;
    }

    public function storeDeposit()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method_id' => 'required',
        ]);

        $Deposit = Deposit::find($this->deposit_id);
        $Deposit->type = $this->type;
        $Deposit->amount = $this->amount;
        $Deposit->charge = $this->charge;
        $Deposit->net_amount = $this->net_amount;
        $Deposit->payment_method_id = $this->payment_method_id;
        $Deposit->account_no = $this->account_no;
        $Deposit->account_details = $this->account_details;
        $Deposit->status = $this->status;
        $Deposit->note = $this->note;
        $Deposit->save();

        $Balance = Balance::whereDepositId($Deposit->id)->firstOrNew(['deposit_id' => $Deposit->id]);
        $Balance->user_id = $Deposit->user_id;
        $Balance->deposit_id = $Deposit->id;
        $Balance->parent_id = Auth::id();
        $Balance->amount = $this->amount;
        $Balance->net_amount = $this->net_amount;
        $Balance->wallet_type = 1;
        $Balance->type = 4;
        $Balance->flow = 1;
        $Balance->generated_by = $Deposit->user_id;
        $Balance->status = $this->status;
        $Balance->note = $this->note;
        $Balance->save();

        $this->dispatch('modalClose', 'DepositModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Your deposit updated successfully');
        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.deposit-list');
    }
}
