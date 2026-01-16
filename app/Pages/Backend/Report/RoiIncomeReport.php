<?php

namespace App\Pages\Backend\Report;

use App\Http\Common\Component;

class RoiIncomeReport extends Component
{
    public function render()
    {
        return view('pages.backend.report.roi-income-report');
    }
}
