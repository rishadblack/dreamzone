<?php

namespace App\Pages\Ecommerce;

use App\Http\Common\Component;

class Checkout extends Component
{
    public function render()
    {
        return view('pages.ecommerce.checkout');
    }
}
