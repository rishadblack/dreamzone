<?php
namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;
use App\Models\Dealer;
use App\Models\OrderItem;
use App\Models\Point;
use App\Models\Product;
use Livewire\Attributes\On;

class InventoryList extends Component
{
    public $search_dealer_id;
    public $Product;
    public $dealer_id;
    public $quantity;
    public $flow;
    public $txn_pin;

    #[On('openInventoryModal')]
    public function openInventoryModal($data = null)
    {
        $this->reset([
            'Product',
            'dealer_id',
            'quantity',
            'flow',
        ]);

        $this->Product = Product::find($data['id']);

        if ($this->Product) {
            $this->dispatch('modalOpen', 'InventoryModal');
        }

        if (isset($data['dealer_id'])) {
            $this->dealer_id = $data['dealer_id'];
        }
    }

    public function storeStock()
    {
        $this->validate([
            'dealer_id' => 'required|exists:dealers,id',
            'quantity' => 'required|numeric|min:1',
            'flow' => 'required|integer',
            // 'txn_pin' => ['required', 'min:4', 'max:8', 'exists:users,pin,id,' . Auth::id()],
        ]);

        $Dealer = Dealer::find($this->dealer_id);

        $OrderItem = new OrderItem();
        $OrderItem->dealer_id = $this->dealer_id;
        $OrderItem->product_id = $this->Product->id;
        $OrderItem->price = $this->Product->net_price;
        $OrderItem->quantity = $this->quantity;
        $OrderItem->subtotal = $OrderItem->price * $OrderItem->quantity;
        $OrderItem->discount_amount = $this->Product->discount_amount * $OrderItem->quantity;
        $OrderItem->net_amount = $OrderItem->subtotal;
        $OrderItem->point = $this->Product->point;
        $OrderItem->net_point = $OrderItem->point * $OrderItem->quantity;
        $OrderItem->flow = $this->flow;
        $OrderItem->status = 1;
        $OrderItem->save();

        $Point = new Point();
        $Point->user_id = $Dealer->user_id;
        $Point->parent_id = auth()->id();
        $Point->order_item_id = $OrderItem->id;
        $Point->value = $OrderItem->net_point;
        $Point->type = 8;
        $Point->flow = $this->flow;
        $Point->generated_by = auth()->id();
        $Point->is_generated = true;
        $Point->status = 1;
        $Point->save();

        $this->dispatch('modalClose', 'InventoryModal');
        $this->dispatch('refreshDatatable');
        $this->alert('success', 'Stock Updated successfully');

        $this->reset();
    }

    public function render()
    {
        return view('pages.ecommerce-admin.inventory-list');
    }
}