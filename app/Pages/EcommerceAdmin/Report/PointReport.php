<?php

namespace App\Pages\EcommerceAdmin\Report;

use App\Http\Common\Component;

class PointReport extends Component
{
    public function render()
    {
        return view('pages.ecommerce-admin.report.point-report');
    }
}
