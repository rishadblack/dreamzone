<?php

namespace App\Pages\Backend\Report;

use App\Http\Common\Component;

class BalanceReport extends Component
{
    public function render()
    {
        return view('pages.backend.report.balance-report');
    }
}
