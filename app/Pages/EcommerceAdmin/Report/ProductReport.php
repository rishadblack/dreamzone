<?php

namespace App\Pages\EcommerceAdmin\Report;

use App\Http\Common\Component;

class ProductReport extends Component
{
    public function render()
    {
        return view('pages.ecommerce-admin.report.product-report');
    }
}
