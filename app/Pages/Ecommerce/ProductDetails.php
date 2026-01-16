<?php

namespace App\Pages\Ecommerce;

use App\Http\Common\Component;

class ProductDetails extends Component
{
    public function render()
    {
        return view('pages.ecommerce.product-details');
    }
}
