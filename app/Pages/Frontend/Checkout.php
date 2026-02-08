<?php
namespace App\Pages\Frontend;

use App\Http\Common\Component;
use App\Models\Balance;
use App\Models\Dealer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Point;
use App\Models\User;
use App\Traits\MemberUpgradeTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class Checkout extends Component
{
    use MemberUpgradeTrait;

    public $dealer;
    public $dealer_id;
    public $type = 1;

    public $name;
    public $mobile;
    public $address;

    public $payment_method_id = 1;

    protected $listeners = [
        'updateCartList' => '$refresh',
    ];

    public function updatedDealerId($value)
    {
        if ($value) {
            $this->dealer = Dealer::with('User')->find($value);
        } else {
            $this->dealer = null;
        }
    }

    public function updatedType($value)
    {
        if ($value != 3) {
            $this->dealer = Dealer::with('User')->office()->first();
            $this->dealer_id = null;
        } else {
            $this->dealer = null;
        }
    }

    public function orderComplete()
    {
        $user = User::sumBalance()->find(Auth::id());
        $carts = collect(session('cart'));

        $getValidation = [
            'payment_method_id' => ['required'],
            'type' => ['required'],
        ];

        if ($this->type == 3) {
            $getValidation = array_merge($getValidation, [
                'dealer_id' => ['required'],
            ]);
        }

        if ($user->hasRole('dealer') && $this->type == 3) {
            $this->alert('error', 'Only Home Delivery and Office Delivery Available.');

            return true;
        }

        $this->validate($getValidation);

        if ($this->payment_method_id == 2 && $user->available_balance <= 0) {
            $this->alert('error', 'You have no balance to purchase');

            return true;
        }

        if ($this->payment_method_id == 2 && $carts->sum('product_price_total') > $user->available_balance) {
            $this->alert('error', 'You have not enough balance to purchase');

            return true;
        }

        if ($user->is_banned) {
            $this->alert('error', 'Your account is banned');

            return true;
        }

        if ($carts->sum('product_price_total') < 0) {
            $this->alert('error', 'Cart is empty. Added some product first');

            return true;
        }

        $dealer = Dealer::with('User')->sumStock();

        if ($user->hasAnyRole('user|guest') && $this->type == 3) {
            // Agent Delivery Condition
            $dealer = $dealer->find($this->dealer_id);
        } else {
            // Home Delivery and Office Delivery
            $dealer = $dealer->whereNotNull('is_office')->first();
        }

        if (! $dealer) {
            $this->alert('error', 'Office not available now, try again later');

            return true;
        }

        foreach ($carts as $cart) {
            $dealerStock = Dealer::sumStock(['product_id' => $cart->id])->find($dealer->id);

            if (! $dealerStock->checkAvailableStock) {
                $this->alert('error', $cart->name . ' is not available', );

                return true;
            }

            if ($dealerStock->checkAvailableStock && $dealerStock->availableStock < $cart->product_quantity) {
                $this->alert('error', $cart->name . ' is out of stock', );

                return true;
            }
        }

        try {
            DB::beginTransaction();
            $order = new Order();
            $order->user_id = $user->id;
            $order->dealer_id = $dealer->id;
            $order->payment_method_id = $this->payment_method_id;
            $order->type = $this->type;
            $order->point = $carts->sum('product_point_total');
            $order->subtotal = $carts->sum('product_price_total');
            $order->discount_amount = $carts->sum('product_discount_total');
            $order->net_amount = $carts->sum('product_price_total');
            $order->delivery_name = $this->name;
            $order->delivery_mobile = $this->mobile;
            $order->delivery_address = $this->address;
            $order->payment_status = $this->payment_method_id == 2 ? 1 : 2;
            $order->delivery_status = 2;
            $order->status = 2;
            $order->save();

            foreach ($carts as $cart) {
                $orderItem = new OrderItem();
                $orderItem->dealer_id = $dealer->id;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cart->id;
                $orderItem->price = $cart->net_price;
                $orderItem->quantity = $cart->product_quantity;
                $orderItem->subtotal = $cart->product_price_total;
                $orderItem->discount_amount = $cart->product_discount_total;
                $orderItem->net_amount = $cart->product_price_total;
                $orderItem->point = $cart->point;
                $orderItem->net_point = $cart->product_point_total;
                $orderItem->flow = 2;
                $orderItem->status = $order->status;
                $orderItem->save();
            }

            if ($this->payment_method_id == 2) {
                $this->userOrderPayout($order);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $this->alert('success', 'System Error. Please contact Administrator.');

            return true;
        }

        session()->forget('cart');

        $this->alert('success', 'Order Submitted Successfully');
        $this->dispatch('updateCartList');

        return true;
    }

    public function userOrderPayout($order)
    {
        $User = auth()->user();

        $Balance = Balance::whereOrderId($order->id)->whereType(3)->whereFlow(2)->firstOrNew();
        $Balance->user_id = $User->id;
        $Balance->order_id = $order->id;
        $Balance->parent_id = $order->Dealer->user_id;
        $Balance->amount = $order->net_amount;
        $Balance->net_amount = $order->net_amount;
        $Balance->wallet_type = 1;
        $Balance->type = 5;
        $Balance->flow = 2;
        $Balance->generated_by = Auth::id();
        $Balance->status = 1;
        $Balance->save();

        $Point = Point::whereOrderId($order->id)->whereType(1)->whereFlow(1)->firstOrNew();
        $Point->user_id = $User->id;
        $Point->order_id = $order->id;
        $Point->parent_id = $order->Dealer->user_id;
        $Point->value = $order->point;
        $Point->type = 1;
        $Point->flow = 1;
        $Point->generated_by = Auth::id();
        $Point->status = 1;
        $Point->save();

        $this->memberUpgrade($User->id);

    }

    public function getStockCheck($productId, $quantity = null)
    {
        if ($productId && $this->dealer) {
            $dealerStock = Dealer::sumStock(['product_id' => $productId])->find($this->dealer->id);

            if (! $dealerStock->checkAvailableStock) {
                return false;
            }

            if ($dealerStock->checkAvailableStock && $quantity && $dealerStock->availableStock < $quantity) {
                return false;
            }
        } else {
            return false;
        }

        return true;
    }

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->mobile = $user->mobile;
        $this->address = $user->address;
    }

    public function render()
    {
        $Balance = Balance::availableBalance()->whereUserId(Auth::id())->whereStatus(1)->whereWalletType(1)->first();

        return view('pages.frontend.checkout', [
            'carts' => session()->get('cart'),
            'user' => Auth::user(),
            'Balance' => $Balance,
        ]);
    }
}
