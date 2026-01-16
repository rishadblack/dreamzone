<?php

namespace App\Pages\Superadmin;

use App\Models\User;
use App\Models\Balance;
use App\Http\Common\Component;
use Livewire\Attributes\On;
use App\Traits\UsernameSearchTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BalanceGenerate extends Component
{
    use UsernameSearchTrait;
    use LivewireAlert;

    public $balance_id;

    public $username;
    public $amount;
    public $status;
    public $note;

    #[On('openBalanceGenerateModal')]
    public function openBalanceGenerateModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editBalanceGenerate($data['id']);
        }
        // dd($data);


        $this->dispatch('modalOpen', 'BalanceGenerateModal');
    }

    public function editBalanceGenerate($id)
    {
        $Balance = Balance::find($id);
        $this->username = $Balance->User->username;
        $this->username_name = $Balance->User->name;
        $this->status = $Balance->status;
        $this->note = $Balance->note;
        $this->amount = $Balance->amount;
        $this->balance_id = $Balance->id;
    }

    public function storeBalanceGenerate()
    {
        $this->validate([
            'username' => ['required', 'exists:users,username'],
            'amount' => 'required|numeric|min:1',
        ]);

        $transferUser = User::whereUsername($this->username)->first();

        $Balance = Balance::findOrNew($this->balance_id);
        $Balance->user_id =  $transferUser->id;
        $Balance->parent_id = Auth::id();
        $Balance->amount = $this->amount;
        $Balance->net_amount = $this->amount;
        $Balance->wallet_type = 1;
        $Balance->type = 2;
        $Balance->flow = 1;
        $Balance->generated_by = Auth::id();
        $Balance->is_generated = Auth::id();
        $Balance->status = $this->status;
        $Balance->note = $this->note;
        $Balance->save();

        $this->dispatch('modalClose', 'BalanceGenerateModal');
        $this->alert('success', 'Account balance generate successfull for ' . $this->username_name);
        $this->dispatch('refreshDatatable');

        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.balance-generate');
    }
}
