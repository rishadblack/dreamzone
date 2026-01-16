<?php

namespace App\Pages\Superadmin;

use App\Http\Common\Component;

class OrderItemList extends Component
{
    public function render()
    {
        return view('pages.order-item-list');
    }
}
