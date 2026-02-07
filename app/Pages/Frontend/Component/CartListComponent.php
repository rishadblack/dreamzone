<?php
namespace App\Pages\Frontend\Component;

use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CartListComponent extends Component
{
    use LivewireAlert;

    public $item_quantity;

    protected $listeners = [
        'addToCart',
        'removeToCart',
        'updateCart' => '$refresh',
    ];

    public function addToCart($productId, $quantity = null)
    {
        $cart = session()->get('cart');

        $product = Product::find($productId);
        $currentQuantity = 0;

        if (isset($cart[$product->id])) {
            $cart[$product->id]['product_quantity'] = $quantity ? $quantity : $cart[$product->id]['product_quantity'] + 1;
            $cart[$product->id]['product_price_total'] = $cart[$product->id]['product_quantity'] * $product->net_price;
            $cart[$product->id]['product_discount_total'] = $cart[$product->id]['product_quantity'] * $product->discount_amount;
            $cart[$product->id]['product_point_total'] = $cart[$product->id]['product_quantity'] * $product->point;
            $currentQuantity = $cart[$product->id]['product_quantity'];
        } else {
            $product->product_quantity = $quantity ? $quantity : 1;
            $product->product_price_total = $product->net_price * $product->product_quantity;
            $product->product_discount_total = $product->discount_amount * $product->product_quantity;
            $product->product_point_total = $product->point * $product->product_quantity;
            $cart[$product->id] = $product;
            $currentQuantity = $product->product_quantity;
        }

        $this->item_quantity[$product->id] = $currentQuantity;

        session()->put('cart', $cart);

        $this->dispatch('updateCartList');

        if (! $quantity) {
            $this->alert('success', $product->name . ' Added Cart Successfully');
        }
    }

    public function removeToCart($productId)
    {
        $carts = session()->get('cart');

        if ($carts[$productId]) {
            unset($carts[$productId]);
        }

        session()->put('cart', $carts);

        $this->dispatch('updateCartList');

        $this->alert('success', 'Remove From Cart Successfully');
    }

    public function cartIncrise($productId)
    {
        $this->addToCart($productId, $this->item_quantity[$productId] + 1);
    }

    public function cartDecrise($productId)
    {
        $this->addToCart($productId, $this->item_quantity[$productId] - 1);
    }

    public function updatedItemQuantity($value, $key)
    {
        $this->addToCart($key, $value);
    }

    public function mount()
    {
        $carts = collect(session()->get('cart'));

        if (collect($carts)->count() > 0) {
            foreach ($carts as $key => $cart) {
                $this->item_quantity[$key] = $cart->product_quantity;
            }
        }
    }

    public function render()
    {
        $carts = session()->get('cart');

        return view('pages.frontend.component.cart-list-component', [
            'carts' => $carts,
        ]);
    }
}