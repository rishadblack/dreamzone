<?php
namespace App\Pages\Frontend\Component;

use Livewire\Component;

class CartTotal extends Component
{
    protected $listeners = [
        'updateCartList' => '$refresh',
    ];

    public function render()
    {
        return view('pages.frontend.component.cart-total', [
            'carts' => session()->get('cart'),
        ]);
    }
}
