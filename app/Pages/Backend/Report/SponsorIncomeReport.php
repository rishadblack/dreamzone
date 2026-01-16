<?php

namespace App\Pages\Backend\Report;

use App\Http\Common\Component;

class SponsorIncomeReport extends Component
{
    public function render()
    {
        return view('pages.backend.report.sponsor-income-report');
    }
}
