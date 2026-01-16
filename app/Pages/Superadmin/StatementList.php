<?php

namespace App\Pages\Superadmin;

use App\Http\Common\Component;
use App\Models\Statement;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class StatementList extends Component
{
    use LivewireAlert;

    public $statement_id;
    public $type;
    public $details;
    public $percentage;
    public $close_date;
    public $status;


    #[On('openStatementModal')]
    public function openStatementModal($data = null)
    {
        $this->reset();

        if (isset($data['id'])) {
            $this->editStatement($data['id']);
        }

        $this->dispatch('modalOpen', 'StatementModal');
    }

    public function storeStatement()
    {
        $this->validate([
            'percentage' => 'required|numeric',
        ]);

        $Statement = Statement::findOrNew($this->statement_id);

        if($Statement->is_distribute) {
            $this->alert('error', 'This statement has been distributed already');
            return;
        }

        $Statement->user_id = Auth::id();
        $Statement->type = $this->type;
        $Statement->percentage = $this->percentage;
        $Statement->close_date = now()->parse($this->close_date)->format('Y-m-d');
        $Statement->status = $this->status;
        $Statement->save();

        $this->dispatch('modalClose', 'StatementModal');

        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Your deposit request has been received successfully');

        $this->reset();
    }

    public function editStatement($id)
    {
        $this->reset();
        $Statement = Statement::find($id);
        $this->type = $Statement->type;
        $this->statement_id = $Statement->id;
        $this->percentage = $Statement->percentage;
        $this->close_date = $Statement->close_date ? $Statement->close_date->format(getTimeFormat()) : null;
        $this->status = $Statement->status;
    }

    public function render()
    {
        return view('pages.superadmin.statement-list');
    }
}
