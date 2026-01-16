<?php

namespace App\Pages\EcommerceAdmin\Report;

use App\Http\Common\Component;

class OrderDeliveryReport extends Component
{
    public function render()
    {
        return view('pages.ecommerce-admin.report.order-delivery-report');
    }
}
