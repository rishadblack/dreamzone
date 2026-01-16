<?php

namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;

class OrderDeliveryList extends Component
{
    public function render()
    {
        return view('pages.ecommerce-admin.order-delivery-list');
    }
}
