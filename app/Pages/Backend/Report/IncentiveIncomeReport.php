<?php

namespace App\Pages\Backend\Report;

use App\Http\Common\Component;

class IncentiveIncomeReport extends Component
{
    public function render()
    {
        return view('pages.backend.report.incentive-income-report');
    }
}
