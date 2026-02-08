<?php
namespace App\Pages\Ecommerce;

use App\Http\Common\Component;
use App\Models\Order;

class OrderList extends Component
{
    public $order;

    protected $listeners = [
        'openOrderModal',
    ];

    public function openOrderModal($data = null)
    {
        $this->dispatch('modalOpen', 'OrderModal');
        $this->reset();

        if ($data && isset($data['id'])) {
            $this->order = Order::with(['User:id,name,username'])->find($data['id']);
        }
    }

    public function render()
    {
        return view('pages.ecommerce.order-list');
    }
}
