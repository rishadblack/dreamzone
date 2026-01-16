<?php

namespace App\Pages\Superadmin;

use App\Models\Order;
use App\Traits\UserTrait;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Common\Component;

class OrderList extends Component
{
    use UserTrait;
    use LivewireAlert;

    public $order_id;
    public $ticket_id;
    public $order_type;
    public $base_capital;
    public $currency;
    public $volume;
    public $comment;
    public $close_price;
    public $close_time;
    public $commission;
    public $swap;
    public $share_percentage;
    public $share_date;
    public $status;

    public function openOrderModal($id = null)
    {
        $this->reset();

        if ($id) {
            $this->editOrder($id);
        }
        $this->dispatch('modalOpen', 'OrderModal');
    }

    public function editOrder($id)
    {
        $Order = Order::find($id);
        $this->order_id = $Order->id;
        $this->ticket_id = $Order->ticket_id;
        $this->order_type = $Order->order_type;
        $this->base_capital = $Order->base_capital;
        $this->currency = $Order->currency;
        $this->volume = $Order->volume;
        $this->comment = $Order->comment;
        $this->close_price = $Order->close_price;
        $this->close_time = $Order->close_time;
        $this->commission = $Order->commission;
        $this->swap = $Order->swap;
        $this->share_percentage = $Order->share_percentage;
        $this->share_date = $Order->share_date;
        $this->status = $Order->status;
    }

    public function storeOrder()
    {
        $this->validate([
            'share_percentage' => 'required|numeric',
            'share_date' => 'required',
        ]);

        $Order = Order::findOrNew($this->order_id);
        $Order->user_id = Auth::id();
        $Order->ticket_id = $this->ticket_id;
        $Order->order_type = $this->order_type;
        $Order->base_capital = $this->base_capital;
        $Order->currency = $this->currency;
        $Order->volume = $this->volume;
        $Order->comment = $this->comment;
        $Order->close_price = $this->close_price;
        $Order->close_time = $this->close_time;
        $Order->commission = $this->commission;
        $Order->swap = $this->swap;
        $Order->share_percentage = $this->share_percentage;
        $Order->share_date = $this->share_date;
        $Order->status = $this->status;
        $Order->save();

        $this->dispatch('modalClose', 'OrderModal');
        $this->alert('success', 'New Order Added Successfully');
        $this->dispatch('refreshdatatable');

        $this->reset();
    }

    public function render()
    {
        return view('pages.order-list')->layout('layouts.backend-layout');
    }
}
