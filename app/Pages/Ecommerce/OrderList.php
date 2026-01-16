<?php

namespace App\Pages\Ecommerce;

use App\Http\Common\Component;

class OrderList extends Component
{
    public function render()
    {
        return view('pages.ecommerce.order-list');
    }
}
