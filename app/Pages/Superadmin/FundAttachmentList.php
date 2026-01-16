<?php

namespace App\Pages\Superadmin;

use App\Models\Balance;
use App\Models\Fund;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Common\Component;

class FundAttachmentList extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'openDetachedModal',
    ];

    public $fund_id;
    public $name;
    public $username;
    public $net_amount;
    public $is_attached_request;
    public $is_attached;
    public $attached_amount;
    public $detached_amount;
    public $note;
    public $status;

    public function openDetachedModal($data = [])
    {
        $this->reset();
        $this->dispatch('modalOpen', 'DetachedModal');

        if (isset($data['id'])) {
            $Fund = Fund::with('User:id,name,username')->find($data['id']);
            $this->fund_id = $Fund->id;
            $this->name = $Fund->User->name;
            $this->username = $Fund->User->username;
            $this->net_amount = numberFormat($Fund->net_amount, true);
            $this->is_attached_request = $Fund->is_attached_request ? $Fund->is_attached_request->format(getTimeFormat()) : null;
            $this->is_attached = $Fund->is_attached ? $Fund->is_attached->format(getTimeFormat()) : 'Not Attached';
            $this->attached_amount = $Fund->attached_amount > 0 ? numberFormat($Fund->attached_amount, true) : 'Not Attached';
            $this->detached_amount = $Fund->detached_amount;
            $this->status = $Fund->status;
        }
    }

    public function storeDetached()
    {
        $this->validate([
            'detached_amount' => 'required|min:1',
        ]);

        $Fund = Fund::find($this->fund_id);
        $Fund->is_detached_request = now();
        $Fund->is_detached = now();
        $Fund->detached_amount = $this->detached_amount;
        $Fund->status = $this->status;

        if ($this->status == 3) {
            $Fund->is_detached_request = null;
            $Fund->is_detached = null;
            $Fund->detached_amount = 0;
        }
        $Fund->save();

        $Balance = Balance::findOrNew($Fund->detached_balance_id);
        $Balance->user_id = $Fund->user_id;
        $Balance->parent_id = $Fund->user_id;
        $Balance->amount = $Fund->detached_amount;
        $Balance->net_amount = $Fund->detached_amount;
        $Balance->wallet_type = 1;
        $Balance->type = 3;
        $Balance->flow = 1;
        $Balance->generated_by = Auth::id();
        $Balance->status = $this->status;
        $Balance->note = $this->note;
        $Balance->save();

        $Fund->detached_balance_id = $Balance->id;
        $Fund->save();

        $this->dispatch('modalClose', 'DetachedModal');

        $this->dispatch('refreshdatatable');

        $this->alert('success', 'Your fund detached submited successfully');

        $this->reset();
    }

    public function render()
    {
        return view('pages.superadmin.fund-attachment-list');
    }
}
