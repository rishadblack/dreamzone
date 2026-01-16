<?php

namespace App\Pages\Backend;

use App\Models\User;
use App\Models\Balance;
use App\Http\Common\Component;
use App\Traits\UsernameSearchTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BalanceList extends Component
{
    use UsernameSearchTrait;
    use LivewireAlert;

    public $username;
    public $amount;
    public $note;
    public $to_note;

    public function storeBalanceTransfer()
    {
        $this->validate([
            'username' => 'required|exists:users,username',
            'amount' => 'required|numeric|min:0',
        ]);

        $transferUser = User::whereUsername($this->username)->first();
        $User = Auth::User();

        if ($transferUser->id == $User->id) {
            $this->addError('username', 'You can not send to yourself');

            return true;
        }

        $availableBalance = Balance::availableBalance()->whereUserId($User->id)->whereStatus(1)->whereWalletType(1)->first()->available_balance;

        if ($availableBalance < 0) {
            $this->addError('amount', 'You have not enough fund to send');

            return true;
        }

        if ($this->amount > $availableBalance) {
            $this->addError('amount', 'You have not enough fund to send');

            return true;
        }

        if ($User->is_banned) {
            $this->alert('error', 'Your account is banned');

            return true;
        }

        if ($User->is_not_transferable) {
            $this->alert('error', 'Your account transfer is blocked');

            return true;
        }

        if (setting('access_transfer') == 'N') {
            $this->alert('error', 'Fund transfer is not allowed at this moment please try again later');
            return true;
        }


        $fromBalance = new Balance();
        $fromBalance->user_id = $User->id;
        $fromBalance->parent_id = $transferUser->id;
        $fromBalance->amount = $this->amount;
        $fromBalance->net_amount = $this->amount;
        $fromBalance->wallet_type = 1;
        $fromBalance->type = 1;
        $fromBalance->flow = 2;
        $fromBalance->generated_by = $User->id;
        $fromBalance->status = 1;
        $fromBalance->note = $this->note;
        $fromBalance->save();

        $toBalance = new Balance();
        $toBalance->user_id = $transferUser->id;
        $toBalance->parent_id = $User->id;
        $toBalance->amount = $this->amount;
        $toBalance->net_amount = $this->amount;
        $toBalance->wallet_type = 1;
        $toBalance->type = 1;
        $toBalance->flow = 1;
        $toBalance->generated_by = $User->id;
        $toBalance->status = 1;
        $toBalance->note = $this->to_note;
        $toBalance->save();

        $this->dispatch('modalClose', 'TransferModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Fund transfered successfully');
        $this->reset();
    }

    public function render()
    {
        return view('pages.backend.balance-list', [
            'available_balance' => Balance::availableBalance()->whereUserId(Auth::id())->whereStatus(1)->whereWalletType(1)->first()->available_balance,
            ]);
    }
}
