<?php

namespace App\Pages\EcommerceAdmin;

use App\Http\Common\Component;

class InventoryList extends Component
{
    public function render()
    {
        return view('pages.ecommerce-admin.inventory-list');
    }
}
