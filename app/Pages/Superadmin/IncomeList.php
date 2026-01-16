<?php

namespace App\Pages\Superadmin;

use App\Models\User;
use App\Models\Income;
use App\Http\Common\Component;
use Livewire\Attributes\On;
use App\Traits\UsernameSearchTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class IncomeList extends Component
{
    use UsernameSearchTrait;
    use LivewireAlert;

    public $income_id;

    public $username;
    public $amount;
    public $type;
    public $status;

    #[On('openIncomeModal')]
    public function openIncomeModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editIncome($data['id']);
        }

        $this->dispatch('modalOpen', 'IncomeModal');
    }

    public function editIncome($id)
    {
        $Income = Income::find($id);
        $this->username = $Income->User->username;
        $this->username_name = $Income->User->name;
        $this->status = $Income->status;
        $this->type = $Income->type;
        $this->amount = $Income->amount;
        $this->income_id = $Income->id;
    }

    public function storeIncome()
    {
        $this->validate([
            'username' => ['required', 'exists:users,username'],
            'amount' => 'required|numeric',
        ]);

        $Income = Income::findOrNew($this->income_id);
        $Income->amount = $this->amount;
        $Income->net_amount = $this->amount;
        $Income->status = $this->status;
        $Income->type = $this->type;
        $Income->save();

        $this->dispatch('modalClose', 'IncomeGenerateModal');
        $this->alert('success', 'Income update successluffy for ' . $this->username_name);
        $this->dispatch('refreshDatatable');

        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.income-list');
    }
}
