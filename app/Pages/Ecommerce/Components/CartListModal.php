<?php

namespace App\Pages\Ecommerce\Components;

use App\Http\Common\Component;

class CartListModal extends Component
{
    public function render()
    {
        return view('pages.ecommerce.components.cart-list-modal');
    }
}
